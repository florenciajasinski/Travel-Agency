<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\App\Resources\AirlineResource;
use Lightit\Backoffice\Airline\Domain\Actions\ListAirlinesAction;

class ListAirlinesController
{
    public function __invoke(
        ListAirlinesAction $listAirlinesAction
    ): JsonResponse {
        $airlines = $listAirlinesAction->execute();

        return AirlineResource::collection($airlines)->response();
    }
}
