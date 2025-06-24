<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Airline\Domain\Actions\DeleteAirlineAction;
use Lightit\Backoffice\Airline\Domain\Models\Airline;

class DeleteAirlineController
{
    public function __invoke(DeleteAirlineAction $deleteAirlineAction, Airline $airline): JsonResponse
    {
        $deleteAirlineAction->execute($airline);

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
