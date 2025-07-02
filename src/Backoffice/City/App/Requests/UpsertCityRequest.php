<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Backoffice\City\Domain\DataTransferObject\CityDto;
use Lightit\Rules\NameUniqueForCities;

class UpsertCityRequest extends FormRequest
{
    public const NAME = 'name';

    public const AIRLINES_IDS = 'airline_id';

    public function rules(): array
    {
        return [
            self::NAME => [
                'string',
                'max:255',
                new NameUniqueForCities(),
                $this->isMethod('post') ? 'required' : 'sometimes',
            ],
            self::AIRLINES_IDS => ['required', 'array'],
            self::AIRLINES_IDS . '.*' => ['integer', 'exists:airlines,id'],
        ];
    }

    public function toDto(): CityDto
    {
        return new CityDto(
            name: $this->string(self::NAME)->toString(),
        );
    }
}
