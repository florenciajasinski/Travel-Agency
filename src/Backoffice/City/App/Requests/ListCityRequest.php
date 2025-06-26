<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Backoffice\Pagination\PaginationDto;

class ListCityRequest extends FormRequest
{
    public const PAGE = 'page';
    public const PER_PAGE = 'per_page';

    public function rules(): array
    {
        return [
            self::PAGE => [
                'integer',
                'min:1',
                'sometimes',
            ],
            self::PER_PAGE => [
                'integer',
                'min:1',
                'max:100',
                'sometimes',
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
        return (int) $this->query('page', 1);
    }

    public function perPage(): int
    {
        return (int) $this->query('per_page', 15);
    }
}
