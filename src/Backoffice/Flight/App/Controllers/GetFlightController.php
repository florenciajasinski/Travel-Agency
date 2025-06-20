<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\Domain\Models\Flight;
use Lightit\Backoffice\Flight\App\Resources\FlightResource;


class GetFlightController
{
    public function __invoke(Flight $flight): JsonResponse
    {
        return FlightResource::make($flight)
            ->response();
    }
}
