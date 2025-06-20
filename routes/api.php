<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Lightit\Backoffice\Flight\App\Controllers\DeleteFlightController;
use Lightit\Backoffice\Flight\App\Controllers\GetFlightController;
use Lightit\Backoffice\Flight\App\Controllers\ListFlightsController;
use Lightit\Backoffice\Flight\App\Controllers\StoreFlightController;
use Lightit\Backoffice\Flight\App\Controllers\UpdateFlightController;

Route::prefix('flights')
    ->group(static function () {
        Route::prefix('{flight}')
            ->group(static function () {
                Route::get('/', GetFlightController::class);
                Route::patch('/', UpdateFlightController::class);
                Route::delete('/', DeleteFlightController::class);
            });
        Route::get('/', ListFlightsController::class);
        Route::post('/', StoreFlightController::class);
    });
