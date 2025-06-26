<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\DataTransferObject;

readonly class CityDto
{
    public function __construct(
        public string $name,
    ) {
    }
}
