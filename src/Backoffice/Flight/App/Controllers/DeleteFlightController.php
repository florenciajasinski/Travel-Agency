<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\Domain\Actions\DeleteFlightAction;
use Lightit\Backoffice\Flight\Domain\Models\Flight;

class DeleteFlightController
{
    public function __invoke(DeleteFlightAction $deleteFlightAction, Flight $flight): JsonResponse
    {
        $deleteFlightAction->execute($flight);

        return response()->json(null, 204);
    }
}
