<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Actions;

use Illuminate\Support\Collection;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;

class ListCityAirlinesAction
{
    /**
     * @return Collection<int, Airline>
     */
    public function execute(City $city): Collection
    {
        return $city->airlines;
    }
}
