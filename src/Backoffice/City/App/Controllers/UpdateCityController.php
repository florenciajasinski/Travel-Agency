<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\City\App\Requests\UpsertCityRequest;
use Lightit\Backoffice\City\App\Resources\CityResource;
use Lightit\Backoffice\City\Domain\Actions\UpsertCityAction;
use Lightit\Backoffice\City\Domain\Models\City;

class UpdateCityController
{
    public function __invoke(
        UpsertCityRequest $upsertCityRequest,
        UpsertCityAction $upsertCityAction,
        City $city,
    ): JsonResponse {
        $city = $upsertCityAction->execute($upsertCityRequest->toDto(), $city);

        return CityResource::make($city)
            ->response();
    }
}
