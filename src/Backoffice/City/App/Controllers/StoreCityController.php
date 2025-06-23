<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\City\App\Requests\StoreCityRequest;
use Lightit\Backoffice\City\App\Resources\CityResource;
use Lightit\Backoffice\City\Domain\Actions\StoreCityAction;

class StoreCityController
{
    public function __invoke(
        StoreCityRequest $storeCityRequest,
        StoreCityAction $storeCityAction,
    ): JsonResponse {
        $city = $storeCityAction->execute($storeCityRequest->toDto());

        return CityResource::make($city)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
