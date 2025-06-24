<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\Domain\Actions;

use Lightit\Backoffice\Flight\Domain\DataTransferObject\FlightDto;
use Lightit\Backoffice\Flight\Domain\Models\Flight;

class StoreFlightAction
{
    public function execute(FlightDto $flightDto): Flight
    {
        $flight = new Flight();

        $flight->airline_id = $flightDto->airlineId;
        $flight->departure_city_id = $flightDto->departureCityId;
        $flight->arrival_city_id = $flightDto->arrivalCityId;
        $flight->departure_time = $flightDto->departureTime;
        $flight->arrival_time = $flightDto->arrivalTime;

        $flight->save();

        return $flight;
    }
}
