<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Actions;

use Lightit\Backoffice\City\Domain\DataTransferObject\CityDto;
use Lightit\Backoffice\City\Domain\Models\City;

class UpsertCityAction
{
    public function execute(CityDto $cityDto, City|null $city = null): City
    {
        if ($city instanceof City) {
            $city->name = $cityDto->name ?: $city->name;
            if ($city->isDirty()) {
                $city->save();
            }
            return $city;
        }
        $newCity = new City();
        $newCity->name = $cityDto->name;
        $newCity->save();

        return $newCity;
    }
}
