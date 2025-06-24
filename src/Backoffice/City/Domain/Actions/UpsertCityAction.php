<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Actions;

use Lightit\Backoffice\City\Domain\DataTransferObject\CityDto;
use Lightit\Backoffice\City\Domain\Models\City;

class UpsertCityAction
{
    public function execute(CityDto $cityDto, City|null $city): City
    {
        if ($city && $city->exists) {
            $city->name = $cityDto->name;
            $city->save();

            return $city;
        }
        $newCity = new City();
        $newCity->name = $cityDto->name;
        $newCity->save();

        return $newCity;
    }
}
