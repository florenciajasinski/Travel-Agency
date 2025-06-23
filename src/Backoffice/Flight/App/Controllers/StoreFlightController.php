<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\App\Requests\StoreFlightRequest;
use Lightit\Backoffice\Flight\App\Resources\FlightResource;
use Lightit\Backoffice\Flight\Domain\Actions\StoreFlightAction;

class StoreFlightController
{
    public function __invoke(
        StoreFlightRequest $storeFlightRequest,
        StoreFlightAction $storeFlightAction,
    ): JsonResponse {
        $flight = $storeFlightAction->execute($storeFlightRequest->toDto());

        return FlightResource::make($flight)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
