<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('passengers')->name('passengers.')->group(function () {
    Volt::route('view/{id}', 'passengers/view')->name('view');
});