<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Actions;

use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;
use Illuminate\Support\Collection;

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
