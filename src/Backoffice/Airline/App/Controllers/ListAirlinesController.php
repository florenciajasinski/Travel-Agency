<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\App\Resources\AirlineResource;
use Lightit\Backoffice\Airline\Domain\Actions\ListAirlinesAction;
use Lightit\Backoffice\Pagination\PaginationRequest;

class ListAirlinesController
{
    public function __invoke(
        ListAirlinesAction $listAirlinesAction,
        PaginationRequest $paginationRequest
    ): JsonResponse {
        $airlines = $listAirlinesAction->execute($paginationRequest->toDto());

        return AirlineResource::collection($airlines)->response();
    }
}
