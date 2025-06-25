<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Actions;

use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;

class ListAirlineCitiesAction
{
    /**
     * @param Airline $airline
     * @return \Illuminate\Support\Collection<int, City>
     */
    public function execute(Airline $airline)
    {
        return $airline->cities;
    }
}
