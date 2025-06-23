<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Backoffice\Flight\Domain\Models\Flight;

/**
 * @extends Factory<\Lightit\Backoffice\Flight\Domain\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * @var class-string<\Lightit\Backoffice\Flight\Domain\Models\Flight>
     */
    protected $model = Flight::class;
    public function definition(): array
    {
        $departure = fake()->dateTimeBetween('+1 days', '+10 days');
        $arrival = fake()->dateTimeBetween($departure, '+12 days');

        return [
            'airline_id' => AirlineFactory::new(),
            'departure_city_id' => CityFactory::new(),
            'arrival_city_id' => CityFactory::new(),
            'departure_time' => $departure,
            'arrival_time' => $arrival,
        ];
    }

}
