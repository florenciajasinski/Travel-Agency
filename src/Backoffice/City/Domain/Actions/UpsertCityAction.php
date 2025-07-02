<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Actions;

use Lightit\Backoffice\City\Domain\DataTransferObject\CityDto;
use Lightit\Backoffice\City\Domain\Models\City;

class UpsertCityAction
{
    public function execute(CityDto $cityDto, City|null $city = null, array $airlineIds = []): City
    {
        $city ??= new City();
        $city->name = $cityDto->name ?: $city->name;

        if ($city->isDirty()) {
            $city->save();
        }
        $airlineIdsWithTime = [];

        foreach ($airlineIds as $id) {
            $airlineIdsWithTime[$id] = [
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $city->airlines()->sync($airlineIdsWithTime);

        return $city;
    }
}
