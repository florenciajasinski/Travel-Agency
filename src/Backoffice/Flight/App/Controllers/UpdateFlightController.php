<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\App\Requests\UpsertFlightRequest;
use Lightit\Backoffice\Flight\App\Resources\FlightResource;
use Lightit\Backoffice\Flight\Domain\Actions\UpdateFlightAction;
use Lightit\Backoffice\Flight\Domain\Models\Flight;

class UpdateFlightController
{
    public function __invoke(
        UpsertFlightRequest $upsertFlightRequest,
        UpdateFlightAction $updateFlightAction,
        Flight $flight,
    ): JsonResponse {
        $flight = $updateFlightAction->execute($upsertFlightRequest->toDto(), $flight);

        return FlightResource::make($flight)
            ->response();
    }
}
