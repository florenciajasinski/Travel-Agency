<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Actions;

use Lightit\Backoffice\Airline\Domain\DataTransferObject\AirlineDto;
use Lightit\Backoffice\Airline\Domain\Models\Airline;

class StoreAirlineAction
{
    public function execute(AirlineDto $airlineDto): Airline
    {
        $airline = new Airline();

        $airline->name = $airlineDto->name;
        $airline->description = $airlineDto->description;

        $airline->save();

        return $airline;
    }
}
