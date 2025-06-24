<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\App\Requests\UpsertAirlineRequest;
use Lightit\Backoffice\Airline\App\Resources\AirlineResource;
use Lightit\Backoffice\Airline\Domain\Actions\UpdateAirlineAction;
use Lightit\Backoffice\Airline\Domain\Models\Airline;

class UpdateAirlineController
{
    public function __invoke(
        UpsertAirlineRequest $upsertAirlineRequest,
        UpdateAirlineAction $updateAirlineAction,
        Airline $airline,
    ): JsonResponse {
        $airline = $updateAirlineAction->execute($upsertAirlineRequest->toDto(), $airline);

        return AirlineResource::make($airline)
            ->response();
    }
}
