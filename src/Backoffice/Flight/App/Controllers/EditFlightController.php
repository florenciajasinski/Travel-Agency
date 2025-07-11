<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Contracts\View\View;
use Lightit\Backoffice\Flight\Domain\Models\Flight;

class EditFlightController
{
    public function __invoke(Flight $flight): View
    {
        return view('flights.edit', ['flight' => $flight]);
    }
}
