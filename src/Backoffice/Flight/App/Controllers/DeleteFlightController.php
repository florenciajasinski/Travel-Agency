<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\Flight\Domain\Models\Flight;



class DeleteFlightController
{
    public function __invoke(Flight $flight): JsonResponse
    {
        $flight->delete();

        return response()->json([
            'message' => 'Flight deleted successfully.'
        ]);
    }
}
