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
        /** @phpstan-ignore-next-line */
        $city = request()->route('city');
        /** @var int $cityId */
        $cityId = $city->id ?? null;
        $existingCity = City::where('name', $value)->first();

        if ($cityId) {
            $currentCity = City::query()->find($cityId);
            if ($currentCity && $currentCity->name === $value) {
                return;
            }
        }
        if ($existingCity && $existingCity->id != $cityId) {
            $fail('The city name must be unique');
        }
    }
}
