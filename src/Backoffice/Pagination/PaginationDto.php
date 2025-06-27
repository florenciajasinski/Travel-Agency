<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Pagination;

readonly class PaginationDto
{
    public function __construct(
        public int $perPage = 15,
        public int $page = 1,
    ) {
    }
}
