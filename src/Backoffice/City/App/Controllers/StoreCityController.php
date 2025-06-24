<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\City\App\Requests\UpsertCityRequest;
use Lightit\Backoffice\City\App\Resources\CityResource;
use Lightit\Backoffice\City\Domain\Actions\StoreCityAction;

class StoreCityController
{
    public function __invoke(
        UpsertCityRequest $upsertCityRequest,
        StoreCityAction $storeCityAction,
    ): JsonResponse {
        $city = $storeCityAction->execute($upsertCityRequest->toDto());

        return CityResource::make($city)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
