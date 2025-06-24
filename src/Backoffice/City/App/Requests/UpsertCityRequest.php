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
        $rules = [
            self::NAME => ['string', 'max:255', Rule::unique('cities', 'name')],
        ];

        $rules[self::NAME][] = $this->isMethod('post') ? 'required' : 'sometimes';

        return $rules;
    }

    public function toDto(): CityDto
    {
        return new CityDto(
            name: $this->string(self::NAME)->toString(),
        );
    }
}
