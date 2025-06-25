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
        /** @phpstan-ignore-next-line */
        $airline = request()->route('airline');
        /** @var int|null $airlineId */
        $airlineId = $airline->id ?? null;

        $existingAirline = Airline::where('name', $value)->first();

        if ($existingAirline && $existingAirline->id !== $airlineId) {
            $fail('The airline name must be unique.');
        }
    }
}
