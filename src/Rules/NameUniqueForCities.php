<?php

declare(strict_types=1);

namespace Lightit\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Lightit\Backoffice\City\Domain\Models\City;

class NameUniqueForCities implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var City|null $city */
        /** @phpstan-ignore-next-line */
        $city = request()->route('city');

        $existingCity = City::where('name', $value)->first();

        /** @var int|null $cityId */
        $cityId = $city->id ?? null;

        if ($existingCity && $existingCity->id !== $cityId) {
            $fail('The city name must be unique.');
        }
    }
}
