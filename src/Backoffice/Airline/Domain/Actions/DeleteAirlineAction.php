<?php

declare(strict_types=1);
namespace Lightit\Backoffice\Airline\Domain\Actions;

use Lightit\Backoffice\Airline\Domain\Models\Airline;

class DeleteAirlineAction
{
    public function execute(Airline $airline): void
    {
        $airline->delete();
    }
}
