<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Actions;
use Lightit\Backoffice\City\Domain\Models\City;
use Lightit\Backoffice\City\Domain\DataTransferObject\CityDto;

class StoreCityAction
{
    public function execute(CityDto $cityDto): City
    {
        $city = new City();

        $city->name = $cityDto->name;

        $city->save();

        return $city;
    }
}
