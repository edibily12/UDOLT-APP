<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('roles')->name('roles.')->group(function () {
    Volt::route('index', 'roles/index')->name('index');
});