<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('passengers')->name('passengers.')->group(function () {
    Volt::route('pending-passengers', 'dashboard/pending-passengers')->name('pending');
    Volt::route('view/{id}', 'passengers/view')->name('view');
});