<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;

use Carbon\CarbonImmutable;
use Database\Factories\AirlineFactory;
use Database\Factories\CityFactory;
use Database\Factories\FlightFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

const FLIGHT_DATETIME_FORMAT = 'Y-m-d H:i:s';

describe('flights', function (): void {
    it('can update a flight successfully', function (): void {
        $flight = FlightFactory::new()->createOne();
        $newAirline = AirlineFactory::new()->createOne();
        $newDepartureCity = CityFactory::new()->createOne();
        $newArrivalCity = CityFactory::new()->createOne();

        $data = [
            'airline_id' => $newAirline->id,
            'departure_city_id' => $newDepartureCity->id,
            'arrival_city_id' => $newArrivalCity->id,
            'departure_time' => now()->addDays(3)->format(FLIGHT_DATETIME_FORMAT),
            'arrival_time' => now()->addDays(4)->format(FLIGHT_DATETIME_FORMAT),
        ];

        $response = putJson("/api/flights/{$flight->id}", $data);

        $response
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json): AssertableJson =>
                $json->has(
                    'data',
                    fn (AssertableJson $json): AssertableJson =>
                    $json
                        ->where('id', $flight->id)
                        ->where('airline_id', $newAirline->id)
                        ->where('departure_city_id', $newDepartureCity->id)
                        ->where('arrival_city_id', $newArrivalCity->id)
                        ->where('departure_time', CarbonImmutable::parse($data['departure_time'])->toJSON())
                        ->where('arrival_time', CarbonImmutable::parse($data['arrival_time'])->toJSON())
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
        $flight = FlightFactory::new()->createOne();
        $airline = AirlineFactory::new()->createOne();
        $departureCity = CityFactory::new()->createOne();
        $arrivalCity = CityFactory::new()->createOne();

        $data = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_time' => now()->addDay()->format(FLIGHT_DATETIME_FORMAT),
            'arrival_time' => now()->addDays(2)->format(FLIGHT_DATETIME_FORMAT),
        ];
        $overrideArray = is_callable($override) ? $override() : $override;
        $data = array_merge($data, is_array($overrideArray) ? $overrideArray : []);

        $response = putJson("/api/flights/{$flight->id}", $data);

        $response->assertUnprocessable();
        $json = (array) $response->json();
        expect($json)->toHaveKey('error');
        /** @var array $error */
        $error = $json['error'];
        expect((array) $error['fields'])->toHaveKey($expectedField);
    })->with([
        'airline_id is required' => [['airline_id' => ''], 'airline_id'],
        'departure_city_id is required' => [['departure_city_id' => ''], 'departure_city_id'],
        'arrival_city_id is required' => [['arrival_city_id' => ''], 'arrival_city_id'],
        'departure_time is required' => [['departure_time' => ''], 'departure_time'],
        'arrival_time is required' => [['arrival_time' => ''], 'arrival_time'],
        'departure_time must be date' => [['departure_time' => 'not-a-date'], 'departure_time'],
        'arrival_time must be date' => [['arrival_time' => 'not-a-date'], 'arrival_time'],
        'arrival_city_id must be different from departure_city_id' => [function (): array {
            $city = CityFactory::new()->createOne();

            return [
                'departure_city_id' => $city->id,
                'arrival_city_id' => $city->id,
            ];
        }, 'arrival_city_id'],
    ]);

    it('returns 404 when trying to update a flight that does not exist', function (): void {
        $nonExistentFlightId = 999999;
        $airline = AirlineFactory::new()->createOne();
        $departureCity = CityFactory::new()->createOne();
        $arrivalCity = CityFactory::new()->createOne();

        $data = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_time' => now()->addDay()->format(FLIGHT_DATETIME_FORMAT),
            'arrival_time' => now()->addDays(2)->format(FLIGHT_DATETIME_FORMAT),
        ];

        $response = putJson("/api/flights/{$nonExistentFlightId}", $data);

        $response->assertNotFound();
    });

    it('does not update if arrival_time is before departure_time', function (): void {
        $flight = FlightFactory::new()->createOne();
        $airline = AirlineFactory::new()->createOne();
        $departureCity = CityFactory::new()->createOne();
        $arrivalCity = CityFactory::new()->createOne();

        $data = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_time' => now()->addDays(2)->format(FLIGHT_DATETIME_FORMAT),
            'arrival_time' => now()->addDay()->format(FLIGHT_DATETIME_FORMAT),
        ];

        $response = putJson("/api/flights/{$flight->id}", $data);

        $response->assertUnprocessable();
        $json = (array) $response->json();
        expect($json)->toHaveKey('error');
        /** @var array $error */
        $error = $json['error'];
        expect((array) $error['fields'])->toHaveKey('arrival_time');
    });

    it('does not update if airline does not exist', function (): void {
        $flight = FlightFactory::new()->createOne();
        $departureCity = CityFactory::new()->createOne();
        $arrivalCity = CityFactory::new()->createOne();

        $data = [
            'airline_id' => 999999,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_time' => now()->addDay()->format(FLIGHT_DATETIME_FORMAT),
            'arrival_time' => now()->addDays(2)->format(FLIGHT_DATETIME_FORMAT),
        ];

        $response = putJson("/api/flights/{$flight->id}", $data);

        $response->assertUnprocessable();
        $json = (array) $response->json();
        /** @var array $error */
        $error = $json['error'];
        expect((array) $error['fields'])->toHaveKey('airline_id');
    });
});
