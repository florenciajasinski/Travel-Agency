<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAirlineCityRequest extends FormRequest
{
    public const AIRLINE_ID = 'airline_id';

    public function rules(): array
    {
        return [
            self::AIRLINE_ID => ['required', 'array'],
            self::AIRLINE_ID . '.*' => ['integer', 'exists:airlines,id'],
        ];
    }
}
