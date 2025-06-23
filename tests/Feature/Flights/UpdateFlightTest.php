<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;

use Database\Factories\AirlineFactory;
use Database\Factories\CityFactory;
use Database\Factories\FlightFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Carbon;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\patchJson;

const FLIGHT_DATETIME_FORMAT = 'Y-m-d H:i:s';

describe('flights', function (): void {
    it('can update a flight successfully', function (): void {
        $flight = FlightFactory::new()->create();
        $newAirline = AirlineFactory::new()->create();
        $newDepartureCity = CityFactory::new()->create();
        $newArrivalCity = CityFactory::new()->create();

        $data = [
            'airline_id' => $newAirline->id,
            'departure_city_id' => $newDepartureCity->id,
            'arrival_city_id' => $newArrivalCity->id,
            'departure_time' => now()->addDays(3)->format(FLIGHT_DATETIME_FORMAT),
            'arrival_time' => now()->addDays(4)->format(FLIGHT_DATETIME_FORMAT),
        ];

        $response = patchJson("/api/flights/{$flight->id}", $data);

        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn ($json) =>
                    $json
                        ->where('id', $flight->id)
                        ->where('airline_id', $newAirline->id)
                        ->where('departure_city_id', $newDepartureCity->id)
                        ->where('arrival_city_id', $newArrivalCity->id)
                        ->where('departure_time', function ($value) use ($data) {
                            return Carbon::parse($value)->format(FLIGHT_DATETIME_FORMAT) === $data['departure_time'];
                        })
                        ->where('arrival_time', function ($value) use ($data) {
                            return Carbon::parse($value)->format(FLIGHT_DATETIME_FORMAT) === $data['arrival_time'];
                        })
                        ->etc()
                )
            );

        assertDatabaseHas('flights', [
            'id' => $flight->id,
            'airline_id' => $newAirline->id,
            'departure_city_id' => $newDepartureCity->id,
            'arrival_city_id' => $newArrivalCity->id,
            'departure_time' => $data['departure_time'],
            'arrival_time' => $data['arrival_time'],
        ]);
    });

    it('cannot update a flight with missing or invalid data', function (array $override, string $expectedField): void {
        $flight = FlightFactory::new()->create();
        $airline = AirlineFactory::new()->create();
        $departureCity = CityFactory::new()->create();
        $arrivalCity = CityFactory::new()->create();

        $data = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_time' => now()->addDay()->format(FLIGHT_DATETIME_FORMAT),
            'arrival_time' => now()->addDays(2)->format(FLIGHT_DATETIME_FORMAT),
        ];
        $data = array_merge($data, $override instanceof \Closure ? $override() : $override);

        $response = patchJson("/api/flights/{$flight->id}", $data);

        $response->assertUnprocessable();
        $json = $response->json();
        expect($json)->toHaveKey('errors');
        expect($json['errors'])->toHaveKey($expectedField);

    })->with([
        'airline_id is required' => [['airline_id' => ''], 'airline_id'],
        'departure_city_id is required' => [['departure_city_id' => ''], 'departure_city_id'],
        'arrival_city_id is required' => [['arrival_city_id' => ''], 'arrival_city_id'],
        'departure_time is required' => [['departure_time' => ''], 'departure_time'],
        'arrival_time is required' => [['arrival_time' => ''], 'arrival_time'],
        'departure_time must be date' => [['departure_time' => 'not-a-date'], 'departure_time'],
        'arrival_time must be date' => [['arrival_time' => 'not-a-date'], 'arrival_time'],
        'arrival_city_id must be different from departure_city_id' => [function () {
            $city = CityFactory::new()->create();
            return [
                'departure_city_id' => $city->id,
                'arrival_city_id' => $city->id,
            ];
        }, 'arrival_city_id'],
    ]);
});
