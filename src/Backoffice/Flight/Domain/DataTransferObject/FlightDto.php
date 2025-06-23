<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\Domain\DataTransferObject;

use Carbon\CarbonImmutable;

readonly class FlightDto
{
    public function __construct(
        public int $airlineId,
        public int $departureCityId,
        public int $arrivalCityId,
        public CarbonImmutable $departureTime,
        public CarbonImmutable $arrivalTime,
    ) {
    }
}
