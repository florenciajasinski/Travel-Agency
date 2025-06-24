<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Backoffice\City\Domain\Actions\DeleteCityAction;
use Lightit\Backoffice\City\Domain\Models\City;

class DeleteCityController
{
    public function __invoke(DeleteCityAction $deleteCityAction, City $city): JsonResponse
    {
        $deleteCityAction->execute($city);

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
