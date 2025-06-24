<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Actions;

use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;

class ListAirlineCitiesAction
{
    public function execute(Airline $airline): City|null
    {
        return $airline->cities()->first();
    }
}
