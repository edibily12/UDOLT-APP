<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('users')->name('users.')->group(function () {
    Volt::route('index', 'users/index')->name('index');
});