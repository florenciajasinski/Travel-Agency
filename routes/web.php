<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Lightit\Shared\App\Exceptions\Http\InvalidActionException;

Route::get('invalid', static fn() => throw new InvalidActionException("Is not valid"));

Route::get('/', static fn() => view('cities.index'));

Route::get('/cities', function () {
    return view('cities.index');
});

Route::get('/airlines', function () {
    return view('airlines.index');
});

Route::get('/flights', function () {
    return view('flights.index');
});

Route::get('/flights/{id}/edit', function ($id) {
    return view('flights.edit', ['flightId' => $id]);
});

