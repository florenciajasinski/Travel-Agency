<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;

use Carbon\CarbonImmutable;
use Database\Factories\AirlineFactory;
use Database\Factories\CityFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe('flights', function (): void {
    it('can create a flight successfully', function (): void {
        $airline = AirlineFactory::new()->createOne();
        $departureCity = CityFactory::new()->createOne();
        $arrivalCity = CityFactory::new()->createOne();

        $data = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_time' => now()->addDay()->format('Y-m-d H:i:s'),
            'arrival_time' => now()->addDays(10)->format('Y-m-d H:i:s'),
        ];

        $response = postJson('/api/flights', $data);

        $response
            ->assertCreated()
            ->assertJson(
                fn (AssertableJson $json): AssertableJson =>
                $json->has(
                    'data',
                    fn (AssertableJson $json): AssertableJson =>
                    $json
                        ->where('airline_id', $airline->id)
                        ->where('departure_city_id', $departureCity->id)
                        ->where('arrival_city_id', $arrivalCity->id)
                        ->where('departure_time', CarbonImmutable::parse($data['departure_time'])->toJSON())
                        ->where('arrival_time', CarbonImmutable::parse($data['arrival_time'])->toJSON())
                        ->etc()
                )
            );
        assertDatabaseHas('flights', [
            'airline_id' => $airline->id,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_time' => $data['departure_time'],
            'arrival_time' => $data['arrival_time'],
        ]);
    });

    it('cannot create a flight with invalid data', function (string $field, mixed $value): void {
        $airline = AirlineFactory::new()->createOne();
        $departureCity = CityFactory::new()->createOne();
        $arrivalCity = CityFactory::new()->createOne();

        $data = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_time' => now()->addDay()->format('Y-m-d H:i:s'),
            'arrival_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
        ];

        $data[$field] = $value;

        $response = postJson('/api/flights', $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([$field], 'error.fields');
    })->with([
        'airline_id is required' => ['airline_id', ''],
        'departure_city_id is required' => ['departure_city_id', ''],
        'arrival_city_id is required' => ['arrival_city_id', ''],
        'departure_time is required' => ['departure_time', ''],
        'arrival_time is required' => ['arrival_time', ''],
        'departure_time must be date' => ['departure_time', 'not-a-date'],
        'arrival_time must be date' => ['arrival_time', 'not-a-date'],
        'arrival_city_id must be different from departure_city_id' => ['arrival_city_id', fn (): \Closure => function () {
            $city = CityFactory::new()->createOne();

            return $city->id;
        }],
        'arrival_time must be after departure_time' => ['arrival_time', fn (): string => now()->subDay()->format(
            'Y-m-d H:i:s'
        )],
    ]);
});
