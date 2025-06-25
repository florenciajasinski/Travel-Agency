<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Actions;

use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;
use Illuminate\Support\Collection;

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
