<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\Domain\Actions\ListAirlineCitiesAction;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\App\Resources\CityResource;

class ListAirlineCitiesController
{
    public function __invoke(
        ListAirlineCitiesAction $listAirlineCitiesAction,
        Airline $airline,
    ): JsonResponse {
        $cities = $listAirlineCitiesAction->execute($airline);

        return CityResource::collection($cities)->response();
    }
}

