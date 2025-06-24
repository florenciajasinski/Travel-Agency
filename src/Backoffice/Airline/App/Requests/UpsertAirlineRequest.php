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
        return [
            self::NAME => ['required', 'string', 'max:255', 'unique:airlines,name'],
            self::DESCRIPTION => ['required', 'string', 'max:255'],
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
