<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\DataTransferObject;

readonly class AirlineDto
{
    public function __construct(
        public string $name,
        public string $description,
    ) {
    }
}
