<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard.home');
});

Auth::routes(['register' => false]);
require __DIR__.'/dashboard.php';