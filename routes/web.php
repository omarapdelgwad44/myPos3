<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['register' => false]);
require __DIR__.'/dashboard.php';