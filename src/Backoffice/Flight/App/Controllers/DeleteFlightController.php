<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\Domain\Models\Flight;
use Lightit\Backoffice\Flight\Domain\Actions\DeleteFlightAction;

class DeleteFlightController
{
    public function __invoke(DeleteFlightAction $deleteFlightAction, Flight $flight): JsonResponse
    {
        $deleteFlightAction->execute($flight);

        return response()->json([
            'message' => 'Flight deleted successfully.',
        ]);
    }
}
