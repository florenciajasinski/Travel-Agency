<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Actions;

use Lightit\Backoffice\City\Domain\Models\City;

class StoreAirlineCityAction
{
    public function execute(City $city, array $airlineIds): void
    {
        $airlineIdsWithTime = [];

        foreach ($airlineIds as $id) {
            $airlineIdsWithTime[$id] = [
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $city->airlines()->sync($airlineIdsWithTime);
    }
}
