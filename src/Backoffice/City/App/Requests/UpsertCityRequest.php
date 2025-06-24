<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\City\Domain\DataTransferObject\CityDto;

class UpsertCityRequest extends FormRequest
{
    public const NAME = 'name';

    public function rules(): array
    {
        return [
            self::NAME => ['required', 'string', 'max:255', Rule::unique('cities', 'name')],
        ];
    }

    public function toDto(): CityDto
    {
        return new CityDto(
            name: $this->string(self::NAME)->toString(),
        );
    }
}
