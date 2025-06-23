<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\App\Resources\FlightResource;
use Lightit\Backoffice\Flight\App\Requests\UpdateFlightRequest;
use Lightit\Backoffice\Flight\Domain\Models\Flight;
use Lightit\Backoffice\Flight\Domain\Actions\UpdateFlightAction;

class UpdateFlightController
{
    public function __invoke(
        UpdateFlightRequest $updateFlightRequest,
        UpdateFlightAction $updateFlightAction,
        Flight $flight
    ): JsonResponse {
        $flight = $updateFlightAction->execute($updateFlightRequest->toDto(), $flight);

        return FlightResource::make($flight)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
