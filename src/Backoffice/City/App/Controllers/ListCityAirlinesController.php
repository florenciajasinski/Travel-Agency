<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\App\Resources\AirlineResource;
use Lightit\Backoffice\City\Domain\Actions\ListCityAirlinesAction;
use Lightit\Backoffice\City\Domain\Models\City;

class ListCityAirlinesController
{
    public function __invoke(
        ListCityAirlinesAction $listCityAirlinesAction,
        City $city,
    ): JsonResponse {
        $airlines = $listCityAirlinesAction->execute($city);

        return AirlineResource::collection($airlines)->response();
    }
}
