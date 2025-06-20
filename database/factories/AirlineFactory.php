<?php

declare(strict_types=1);

namespace Database\Factories;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\Lightit\Backoffice\Airline\Domain\Models\Airline>
 */
class AirlineFactory extends Factory
{
    /**
     * @var class-string<\Lightit\Backoffice\Airline\Domain\Models\Airline>
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
