<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;

use Illuminate\Contracts\View\View;
use Lightit\Backoffice\City\Domain\Models\City;

class EditCityController
{
    public function __invoke(City $city): View
    {
        return view('cities.edit', ['city' => $city]);
    }
}
