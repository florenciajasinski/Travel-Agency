<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\App\Requests\UpsertAirlineRequest;
use Lightit\Backoffice\Airline\App\Resources\AirlineResource;
use Lightit\Backoffice\Airline\Domain\Actions\UpsertAirlineAction;
use Lightit\Backoffice\Airline\Domain\Models\Airline;

class UpdateAirlineController
{
    public function __invoke(
        UpsertAirlineRequest $upsertAirlineRequest,
        UpsertAirlineAction $upsertAirlineAction,
        Airline $airline,
    ): JsonResponse {
        $airline = $upsertAirlineAction->execute($upsertAirlineRequest->toDto(), $airline);

        return AirlineResource::make($airline)
            ->response();
    }
}
