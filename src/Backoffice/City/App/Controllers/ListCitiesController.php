<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;
use Lightit\Backoffice\City\App\Resources\CityResource;

use Lightit\Backoffice\City\Domain\Actions\ListCitiesAction;

use Illuminate\Http\JsonResponse;

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
