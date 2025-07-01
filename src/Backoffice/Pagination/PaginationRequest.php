<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Pagination;

use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
{
    public const PAGE = 'page';

    public const PER_PAGE = 'per_page';

    public function rules(): array
    {
        return [
            self::PAGE => [
                'sometimes',
                'integer',
                'min:1',
            ],
            self::PER_PAGE => [
                'sometimes',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }

    public function toDto(): PaginationDto
    {
        return new PaginationDto(
            perPage: $this->perPage(),
            page: $this->page(),
        );
    }

    public function page(): int
    {
        return $this->integer(self::PAGE, 1);
    }

    public function perPage(): int
    {
        return $this->integer(self::PER_PAGE, 15);
    }
}
