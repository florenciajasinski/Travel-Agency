<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\Domain\DataTransferObject;

use Carbon\CarbonImmutable;
use DateTime;

class FlightDto
{
    public function __construct(
        public readonly int $airlineId,
        public readonly int $departureCityId,
        public readonly int $arrivalCityId,
        public readonly CarbonImmutable $departureTime,
        public readonly CarbonImmutable $arrivalTime,
        public readonly int|null $flightId,
    ) {
    }
}
