<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\Domain\Actions\StoreAirlineCityAction;
use Lightit\Backoffice\City\Domain\Models\City;

class StoreAirlineCityController
{
    public function __invoke(
        StoreAirlineCityAction $storeAirlineCityAction,
        City $city,
    ): JsonResponse {
        /** @phpstan-ignore-next-line */
        $airlineData = request()->all();
        $airlineId = $airlineData['airline_id'];
        $airlineIdsWithData = [$airlineId];

        $storeAirlineCityAction->execute($city, $airlineIdsWithData);

        return response()->json([
            'message' => 'Airline city stored successfully',
            'data' => [
                'airline_city' => [
                    'city_id' => $city->id,
                    'airline_ids' => $airlineIdsWithData,
                ],
            ],
        ]);
    }
}
