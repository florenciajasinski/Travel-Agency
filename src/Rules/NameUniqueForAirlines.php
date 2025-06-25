<?php

declare(strict_types=1);

namespace Lightit\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Lightit\Backoffice\Airline\Domain\Models\Airline;

class NameUniqueForAirlines implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var Airline $airline */
        /** @phpstan-ignore-next-line */
        $airline = request()->route('airline');

        $existingAirline = Airline::where('name', $value)->first();

        /** @var int|null $airlineId */
        $airlineId = $airline->id ?? null;

        if ($existingAirline && $existingAirline->id !== $airlineId) {
            $fail('The airline name must be unique.');
        }
    }
}
