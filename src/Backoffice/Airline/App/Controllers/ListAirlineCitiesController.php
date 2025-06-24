<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\App\Resources\AirlineResourceCity;
use Lightit\Backoffice\Airline\Domain\Actions\ListAirlineCitiesAction;
use Lightit\Backoffice\Airline\Domain\Models\Airline;

class ListAirlineCitiesController
{
    public function __invoke(
        ListAirlineCitiesAction $listAirlineCitiesAction,
        Airline $airline,
    ): JsonResponse {
        $city = $listAirlineCitiesAction->execute($airline);

        return AirlineResourceCity::collection([$city])
            ->response();
    }
}
