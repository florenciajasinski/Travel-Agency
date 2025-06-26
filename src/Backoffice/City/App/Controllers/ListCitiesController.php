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
        $cities = $listCitiesAction->execute();

        return CityResource::collection($cities)
            ->response();
    }
}
