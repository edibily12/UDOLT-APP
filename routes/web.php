<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
//    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    \App\Helpers\Helper::includeRoutes(__DIR__ . '/web/');

    Route::post('/fetch-location', [\App\Http\Controllers\PassengerController::class, 'fetchLocation']);
});
