<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;

use Database\Factories\AirlineFactory;
use Database\Factories\FlightFactory;
use Illuminate\Database\Eloquent\Collection;
use function Pest\Laravel\getJson;

describe('flights', function (): void {
    /** @see StoreFlightController */
    it('can list flights successfully', function (): void {
        $flights = FlightFactory::new()
            ->createMany(5);

        getJson(url('/api/flights'))
            ->assertSuccessful()
            ->assertJsonCount(5, 'data');
    });

    it('can filter flights by airline', function (): void {
        $airline = AirlineFactory::new()->createOne();
        FlightFactory::new()
            ->count(3)
            ->create(['airline_id' => $airline->id]);

        getJson(url('/api/flights?airline_id=' . $airline->id))
            ->assertSuccessful()
            ->assertJsonCount(3, 'data')
            ->assertJsonFragment(['airline_id' => $airline->id]);
    });

    it('can sort flights by departure time ascending', function (): void {
        $early = FlightFactory::new()->create(['departure_time' => now()->addHours(1)]);
        $late = FlightFactory::new()->create(['departure_time' => now()->addHours(5)]);
        $earlyFlight = $early instanceof Collection ? $early->first() : $early;
        $lateFlight = $late instanceof Collection ? $late->first() : $late;

        getJson(url('/api/flights?sort=departure_time'))
            ->assertSuccessful()
            ->assertSeeInOrder([
                $earlyFlight ? $earlyFlight->id : '',
                $lateFlight ? $lateFlight->id : '',
            ]);
    });
});
