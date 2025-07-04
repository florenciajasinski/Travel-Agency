<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\DataTransferObject\CityDto;
use Lightit\Rules\NameUniqueForCities;

class UpsertCityRequest extends FormRequest
{
    public const NAME = 'name';

    public const AIRLINE_IDS = 'airline_ids';

    public function rules(): array
    {
        return [
            self::NAME => [
                'required',
                'string',
                'max:255',
                new NameUniqueForCities(),
            ],
            self::AIRLINE_IDS => [
                $this->isMethod('put') ? 'required' : 'sometimes',
                'array',
            ],
            self::AIRLINE_IDS . '.*' => [
                'integer',
                Rule::exists(Airline::class, 'id'),
            ],
        ];
    }

    public function toDto(): CityDto
    {
        return new CityDto(
            name: $this->string(self::NAME)->toString(),
            airlineIds: (array) $this->input(self::AIRLINE_IDS, []),
        );
    }
}
