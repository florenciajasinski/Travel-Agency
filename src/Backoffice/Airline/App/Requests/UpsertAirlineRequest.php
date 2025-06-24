<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Backoffice\Airline\Domain\DataTransferObject\AirlineDto;

class UpsertAirlineRequest extends FormRequest
{
    public const NAME = 'name';

    public const DESCRIPTION = 'description';

    public function rules(): array
    {
        $rules = [
            self::NAME => ['string', 'max:255', 'unique:airlines,name'],
            self::DESCRIPTION => ['string', 'max:255'],
        ];

        if ($this->isMethod('post')) {
            $rules[self::NAME][] = 'required';
            $rules[self::DESCRIPTION][] = 'required';
        } else {
            $rules[self::NAME][] = 'sometimes';
            $rules[self::DESCRIPTION][] = 'sometimes';
        }

        return $rules;
    }

    public function toDto(): AirlineDto
    {
        return new AirlineDto(
            name: $this->string(self::NAME)->toString(),
            description: $this->string(self::DESCRIPTION)->toString(),
        );
    }
}
