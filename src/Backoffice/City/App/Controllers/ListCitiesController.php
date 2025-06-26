<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;

use Illuminate\Http\JsonResponse;

use Lightit\Backoffice\City\App\Resources\CityResource;

use Lightit\Backoffice\City\Domain\Actions\ListCitiesAction;

class ListCitiesController
{
    public function __invoke(
        ListCitiesAction $listCitiesAction,
    ): JsonResponse {
        /** @phpstan-ignore-next-line */
        $page = (int) request()->query('page', 1);
        /** @phpstan-ignore-next-line */
        $perPage = (int) request()->query('per_page', 15);
        $cities = $listCitiesAction->execute(perPage: $perPage, page: $page);

        return CityResource::collection($cities)
            ->response();
    }
}
