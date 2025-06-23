<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Database\Factories\FlightFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Testing\Fluent\AssertableJson;
use Lightit\Backoffice\Flight\App\Resources\FlightResource;
use function Pest\Laravel\getJson;

describe('flights', function (): void {
    /** @see GetFlightController */
    it('retrieves a flight and returns a successful response', function (): void {
        $existingFlight = FlightFactory::new()->createOne();

        getJson("api/flights/$existingFlight->id")
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson(
                fn (AssertableJson $json): AssertableJson =>
                $json->has(
                    'data',
                    fn (AssertableJson $json): AssertableJson => $json->whereAll(
                        collect(FlightResource::make($existingFlight)->resolve())
                            ->map(function ($value) {
                                return $value instanceof \Carbon\CarbonInterface ? $value->toJSON() : $value;
                            })
                            ->all()
                    )
                )
            );
    });

    it('returns a 404 response when flight is not found', function (): void {
        $nonExistentFlightId = 99999;

        getJson("api/flights/{$nonExistentFlightId}")
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND);
    });
});
