<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\App\Resources\FlightResource;
use Lightit\Backoffice\Flight\Domain\Actions\ListFlightsAction;
use Lightit\Backoffice\Pagination\PaginationRequest;

class ListFlightsController
{
    public function __invoke(
        ListFlightsAction $listFlightsAction,
        PaginationRequest $paginationRequest,
    ): JsonResponse {
        $flights = $listFlightsAction->execute($paginationRequest->toDto());

        return FlightResource::collection($flights)->response();
    }
}
