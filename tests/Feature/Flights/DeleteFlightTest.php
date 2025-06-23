<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;

use Database\Factories\FlightFactory;
use Illuminate\Http\JsonResponse;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

describe('flights', function (): void {
    /** @see DeleteFlightController */
    it('deletes a flight and returns a successful response', function (): void {
        $existingFlight = FlightFactory::new()->createOne();
        $response = deleteJson("api/flights/$existingFlight->id");
        $response->assertStatus(JsonResponse::HTTP_OK);

        assertDatabaseMissing('flights', ['id' => $existingFlight->id]);
    });
});
