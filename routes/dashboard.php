<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/dashboard',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', ]
    ], function(){ 
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard.home');
        Route::resource('users', App\Http\Controllers\UserController::class)->names('dashboard.users');
        Route::resource('categories', App\Http\Controllers\CategoryController::class)->names('dashboard.categories');
        Route::resource('products', App\Http\Controllers\productController::class)->names('dashboard.products');
        Route::resource('clints', App\Http\Controllers\clintController::class)->names('dashboard.clints');
        Route::get('clints/{clint}/orders/create', App\Livewire\OrderCreate::class)->name('clints.orders.create');

        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/custom/livewire/update', $handle);
        });
    });
