<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\CityFactory;
use Database\Factories\AirlineFactory;
use Database\Factories\FlightFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        CityFactory::new()->createMany(10);
        AirlineFactory::new()->createMany(10);
        FlightFactory::new()->createMany(10);
    }
}
