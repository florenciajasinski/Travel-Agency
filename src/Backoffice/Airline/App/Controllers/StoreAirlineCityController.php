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
        // @var int $airlineId
        /** @phpstan-ignore-next-line */
        $airlineId = (int) request()->input('airline_id');
        $airlineCity = $storeAirlineCityAction->execute($city, $airlineId);

        return response()->json([
            'data' => $airlineCity,
        ]);
    }
}
