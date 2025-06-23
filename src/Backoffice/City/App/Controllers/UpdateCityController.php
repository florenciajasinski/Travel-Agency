<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\City\App\Requests\UpdateCityRequest;
use Lightit\Backoffice\City\App\Resources\CityResource;
use Lightit\Backoffice\City\Domain\Actions\UpdateCityAction;
use Lightit\Backoffice\City\Domain\Models\City;

class UpdateCityController
{
    public function __invoke(
        UpdateCityRequest $updateCityRequest,
        UpdateCityAction $updateCityAction,
        City $city,
    ): JsonResponse {
        $city = $updateCityAction->execute($updateCityRequest->toDto(), $city);

        return CityResource::make($city)
            ->response();
    }
}
