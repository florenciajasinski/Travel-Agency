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

    public const AIRLINES_IDS = 'airline_id';

    public function rules(): array
    {
        return [
            self::NAME => [
                'required',
                'string',
                'max:255',
                new NameUniqueForCities(),
            ],
            self::AIRLINES_IDS => [
                $this->isMethod('put') ? 'required' : 'sometimes',
                'array',
            ],
            self::AIRLINES_IDS . '.*' => [
                'integer',
                Rule::exists(Airline::class, 'id'),
            ],
        ];
    }

    public function toDto(): CityDto
    {
        return new CityDto(
            name: $this->string(self::NAME)->toString(),
            airlineIds: (array) $this->input(self::AIRLINES_IDS, []),
        );
    }
}
