<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Lightit\Shared\App\Exceptions\Http\InvalidActionException;
use Lightit\Backoffice\Flight\App\Controllers\EditFlightController;

Route::get('invalid', static fn() => throw new InvalidActionException("Is not valid"));

Route::get('/', static fn() => view('cities.index'));

Route::get('/cities', function () {
    return view('cities.index');
});

Route::get('/cities/{id}/edit', function ($id) {
    return view('cities.edit', ['cityId' => $id]);
});

Route::get('/airlines', function () {
    return view('airlines.index');
});

Route::get('/flights', function () {
    return view('flights.index');
});

Route::get('/flights/{flight}/edit', EditFlightController::class);
