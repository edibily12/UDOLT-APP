<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('vehicles')->name('vehicles.')->group(function () {
    Volt::route('index', 'vehicles/index')->name('index');
});