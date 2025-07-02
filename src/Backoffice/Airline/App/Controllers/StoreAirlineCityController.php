<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\App\Requests\StoreAirlineCityRequest;
use Lightit\Backoffice\Airline\Domain\Actions\StoreAirlineCityAction;
use Lightit\Backoffice\City\Domain\Models\City;

class StoreAirlineCityController
{
    public function __invoke(
        StoreAirlineCityRequest $storeAirlineCityRequest,
        StoreAirlineCityAction $storeAirlineCityAction,
        City $city,
    ): JsonResponse {
        /** @var array<int> $airlineIds */
        $airlineIds = $storeAirlineCityRequest->input('airline_id');

        $storeAirlineCityAction->execute($city, $airlineIds);

        return response()->json([
            'data' => [
                'airline_city' => [
                    'city_id' => $city->id,
                    'airline_ids' => $airlineIds,
                ],
            ],
        ]);
    }
}
