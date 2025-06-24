<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
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
        $departure = CarbonImmutable::instance(fake()->dateTimeBetween('+1 days', '+10 days'));
        $arrival = CarbonImmutable::instance(fake()->dateTimeBetween($departure, '+12 days'));
        return [
            'airline_id' => AirlineFactory::new(),
            'departure_city_id' => CityFactory::new(),
            'arrival_city_id' => CityFactory::new(),
            'departure_time' => $departure,
            'arrival_time' => $arrival,
        ];
    }
}
