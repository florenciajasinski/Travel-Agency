<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Lightit\Backoffice\Flight\App\Controllers\DeleteFlightController;
use Lightit\Backoffice\Flight\App\Controllers\GetFlightController;
use Lightit\Backoffice\Flight\App\Controllers\ListFlightsController;
use Lightit\Backoffice\Flight\App\Controllers\StoreFlightController;
use Lightit\Backoffice\Flight\App\Controllers\UpdateFlightController;
use Lightit\Backoffice\City\App\Controllers\DeleteCityController;
use Lightit\Backoffice\City\App\Controllers\ListCitiesController;
use Lightit\Backoffice\City\App\Controllers\StoreCityController;
use Lightit\Backoffice\City\App\Controllers\UpdateCityController;

Route::prefix('flights')
    ->group(static function (): void {
        Route::prefix('{flight}')
            ->group(static function (): void {
                Route::get('/', GetFlightController::class);
                Route::put('/', UpdateFlightController::class);
                Route::delete('/', DeleteFlightController::class);
            });
        Route::get('/', ListFlightsController::class);
        Route::post('/', StoreFlightController::class);
    });

Route::prefix('cities')
    ->group(static function (): void {
        Route::prefix('{city}')
            ->group(static function (): void {
               // Route::patch('/', UpdateCityController::class);
               // Route::delete('/', DeleteCityController::class);
            });
       // Route::get('/', ListCitiesController::class);
        //Route::post('/', StoreCityController::class);
    });
