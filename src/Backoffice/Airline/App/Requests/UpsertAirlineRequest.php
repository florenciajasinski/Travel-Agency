<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Backoffice\Airline\Domain\DataTransferObject\AirlineDto;
use Lightit\Rules\NameUniqueForAirlines;

class UpsertAirlineRequest extends FormRequest
{
    public const NAME = 'name';

    public const DESCRIPTION = 'description';

    public function rules(): array
    {
        return [
            self::NAME => [
                'string',
                'max:255',
                new NameUniqueForAirlines(),
                'required',
            ],
            self::DESCRIPTION => [
                'string',
                'max:255',
                'required',
            ],
        ];
    }

    public function toDto(): AirlineDto
    {
        return new AirlineDto(
            name: $this->string(self::NAME)->toString(),
            description: $this->string(self::DESCRIPTION)->toString(),
        );
    }
}
