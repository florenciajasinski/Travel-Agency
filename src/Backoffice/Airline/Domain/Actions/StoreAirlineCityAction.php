<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Actions;

use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;

class StoreAirlineCityAction
{
    /**
     * Sync multiple airlines to a city with custom pivot data.
     *
     * @param array $airlineIdsWithData Array of airline_id => [pivot_data]
     *
     */
    public function execute(City $city, array $airlineIdsWithData): void
    {
        // If only IDs are passed (not arrays), add timestamps automatically
        $syncData = [];
        foreach ($airlineIdsWithData as $airlineId => $pivotData) {
            if (! is_array($pivotData)) {
                $airlineId = $pivotData;
                $pivotData = [
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $syncData[$airlineId] = $pivotData;
        }

        $city->airlines()->sync($syncData);
    }
}
