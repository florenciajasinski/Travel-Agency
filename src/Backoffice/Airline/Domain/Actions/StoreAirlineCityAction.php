<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Actions;

use Lightit\Backoffice\Airline\Domain\Models\AirlineCity;
use Lightit\Backoffice\City\Domain\Models\City;

class StoreAirlineCityAction
{
    public function execute(City $city, int $airlineId): AirlineCity
    {
        $airlineCity = new AirlineCity();
        $airlineCity->airline_id = $airlineId;
        $airlineCity->city_id = $city->id;
        $airlineCity->save();

        return $airlineCity;
    }
}
