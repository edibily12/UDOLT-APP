<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('drivers')->name('drivers.')->group(function () {
    Volt::route('index', 'drivers/index')->name('index');
    Volt::route('statistics', 'drivers/statistics')->name('statistics');
    Volt::route('view/{id}', 'drivers/view')->name('view');
});