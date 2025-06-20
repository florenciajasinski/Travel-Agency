<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\App\Requests\UpsertFlightRequest;
use Lightit\Backoffice\Flight\App\Resources\FlightResource;
use Lightit\Backoffice\Flight\Domain\Actions\UpsertFlightAction;

class StoreFlightController
{
    public function __invoke(UpsertFlightRequest $updateFlightRequest, UpsertFlightAction $updateFlightAction): JsonResponse
    {
        $flight = $updateFlightAction->execute($updateFlightRequest->toDto());

        return FlightResource::make($flight)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
