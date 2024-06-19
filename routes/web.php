<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Fallback route
Route::fallback(function () {
    return view('home');
});