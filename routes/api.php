<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Lightit\Backoffice\Flight\App\Controllers\DeleteFlightController;
use Lightit\Backoffice\Flight\App\Controllers\GetFlightController;
use Lightit\Backoffice\Flight\App\Controllers\ListFlightsController;
use Lightit\Backoffice\Flight\App\Controllers\StoreFlightController;
use Lightit\Backoffice\Flight\App\Controllers\UpdateFlightController;
use Lightit\Backoffice\City\App\Controllers\StoreCityController;
use Lightit\Backoffice\City\App\Controllers\UpdateCityController;
use Lightit\Backoffice\Airline\App\Controllers\DeleteAirlineController;
use Lightit\Backoffice\Airline\App\Controllers\ListAirlinesController;
use Lightit\Backoffice\Airline\App\Controllers\ListAirlineCitiesController;
use Lightit\Backoffice\Airline\App\Controllers\StoreAirlineController;
use Lightit\Backoffice\Airline\App\Controllers\UpdateAirlineController;
use Lightit\Backoffice\City\App\Controllers\DeleteCityController;
use Lightit\Backoffice\City\App\Controllers\ListCitiesController;
use Lightit\Backoffice\City\App\Controllers\ListCityAirlinesController;

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
               Route::put('/', UpdateCityController::class);
               Route::delete('/', DeleteCityController::class);
               Route::get('/airlines', ListCityAirlinesController::class);
            });
       Route::get('/', ListCitiesController::class);
       Route::post('/', StoreCityController::class);
    });

Route::prefix('airlines')
    ->group(static function (): void {
        Route::prefix('{airline}')
            ->group(static function (): void {
               Route::put('/', UpdateAirlineController::class);
               Route::delete('/', DeleteAirlineController::class);
               Route::get('/cities', ListAirlineCitiesController::class);
            });
       Route::get('/', ListAirlinesController::class);
       Route::post('/', StoreAirlineController::class);
    });

