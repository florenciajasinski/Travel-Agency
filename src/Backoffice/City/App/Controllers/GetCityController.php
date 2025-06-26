<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\City\App\Resources\CityResource;
use Lightit\Backoffice\City\Domain\Models\City;

class GetCityController
{
    public function __invoke(City $city): JsonResponse
    {
        return CityResource::make($city)->response();
    }
}
