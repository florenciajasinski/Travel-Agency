<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Backoffice\City\Domain\Models\City;

/**
 * @extends Factory<\Lightit\City>
 */
class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class=-string<City>
     */
    protected $model = City::class;
    public function definition(): array
    {
        return [
            'name' => fake()->city()
        ];
    }
}
