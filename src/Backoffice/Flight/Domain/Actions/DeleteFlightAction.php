<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\Domain\Actions;
use Lightit\Backoffice\Flight\Domain\Models\Flight;



class DeleteFlightAction{
    public function execute(Flight $flight): void
    {
        $flight->delete();
    }
}
