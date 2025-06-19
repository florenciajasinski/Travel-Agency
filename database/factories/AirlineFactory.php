<?php

declare(strict_types=1);

namespace Database\Factories;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\Lightit\City>
 */
class AirlineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Airline>
     */
    protected $model = Airline::class;
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->text()
        ];
    }
}
