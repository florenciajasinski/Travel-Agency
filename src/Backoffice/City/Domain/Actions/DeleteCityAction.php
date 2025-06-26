<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Actions;

use Lightit\Backoffice\City\Domain\Models\City;

class DeleteCityAction
{
    public function execute(City $city): void
    {
        $city->delete();
    }
}
