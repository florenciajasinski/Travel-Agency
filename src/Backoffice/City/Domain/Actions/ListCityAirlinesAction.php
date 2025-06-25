<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Actions;

use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;

class ListCityAirlinesAction
{
    /**
     * @param City $city
     * @return \Illuminate\Support\Collection<int, Airline>
     */
    public function execute(City $city)
    {
        return $city->airlines;
    }
}
