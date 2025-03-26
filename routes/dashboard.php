<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/dashboard',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'role:super_admin' ]
    ], function(){ 
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');
        Route::resource('users', App\Http\Controllers\UserController::class)->names('dashboard.users');
    });
