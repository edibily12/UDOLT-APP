<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('permissions')->name('permissions.')->group(function () {
    Volt::route('index', 'permissions/index')->name('index');
});