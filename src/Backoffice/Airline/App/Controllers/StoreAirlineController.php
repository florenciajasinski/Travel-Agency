<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\App\Requests\UpsertAirlineRequest;
use Lightit\Backoffice\Airline\App\Resources\AirlineResource;
use Lightit\Backoffice\Airline\Domain\Actions\UpsertAirlineAction;

class StoreAirlineController
{
    public function __invoke(
        UpsertAirlineRequest $upsertAirlineRequest,
        UpsertAirlineAction $upsertAirlineAction,
    ): JsonResponse {
        $airline = $upsertAirlineAction->execute($upsertAirlineRequest->toDto());

        return AirlineResource::make($airline)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
