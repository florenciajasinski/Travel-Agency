<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\Domain\DataTransferObject;

use DateTime;

class FlightDto
{
    public function __construct(
        public readonly int $airlineId,
        public readonly int $departureCityId,
        public readonly int $arrivalCityId,
        public readonly DateTime $departureTime,
        public readonly DateTime $arrivalTime,
        public readonly int|null $flightId,
    ) {
    }
}
