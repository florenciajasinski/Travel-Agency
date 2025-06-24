<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\App\Resources\FlightResource;
use Lightit\Backoffice\Flight\Domain\Actions\ListFlightsAction;

class ListFlightsController
{
    public function __invoke(
        ListFlightsAction $listFlightsAction,
    ): JsonResponse {
        $flights = $listFlightsAction->execute();

        return FlightResource::collection($flights)
            ->response();
    }
}
