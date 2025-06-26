<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\App\Resources\AirlineResource;
use Lightit\Backoffice\Airline\Domain\Models\Airline;

class GetAirlineController
{
    public function __invoke(Airline $airline): JsonResponse
    {
        return AirlineResource::make($airline)->response();
    }
}
