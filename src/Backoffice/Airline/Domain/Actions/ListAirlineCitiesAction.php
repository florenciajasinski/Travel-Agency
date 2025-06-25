<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Actions;

use Illuminate\Support\Collection;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;

class ListAirlineCitiesAction
{
    /**
     * @return Collection<int, City>
     */
    public function execute(Airline $airline): Collection
    {
        return $airline->cities;
    }
}
