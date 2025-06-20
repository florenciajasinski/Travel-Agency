<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Backoffice\City\Domain\Models\City;

/**
 * @extends Factory<\Lightit\Backoffice\City\Domain\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * @var class-string<\Lightit\Backoffice\City\Domain\Models\City>
     */
    protected $model = City::class;
    public function definition(): array
    {
        return [
            'name' => fake()->city()
        ];
    }
}
