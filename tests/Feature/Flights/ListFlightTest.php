<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;
use Database\Factories\FlightFactory;
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
});
