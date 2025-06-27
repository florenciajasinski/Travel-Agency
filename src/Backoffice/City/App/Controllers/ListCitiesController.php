<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;

use Illuminate\Http\JsonResponse;



use Lightit\Backoffice\City\App\Resources\CityResource;
use Lightit\Backoffice\City\Domain\Actions\ListCitiesAction;
use Lightit\Backoffice\Pagination\PaginationRequest;

class ListCitiesController
{
    public function __invoke(
        ListCitiesAction $listCitiesAction,
        PaginationRequest $paginationRequest,
    ): JsonResponse {
        $cities = $listCitiesAction->execute($paginationRequest->toDto());

        return CityResource::collection($cities)->response();
    }
}
