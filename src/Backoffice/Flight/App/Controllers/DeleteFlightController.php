<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\Domain\Actions\DeleteFlightAction;
use Lightit\Backoffice\Flight\Domain\Models\Flight;
use Lightit\Backoffice\Flight\App\Resources\FlightResource;

class DeleteFlightController
{
    public function __invoke(DeleteFlightAction $deleteFlightAction, Flight $flight): JsonResponse
    {
        $deleteFlightAction->execute($flight);

        return FlightResource::make($flight)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
    }
}
