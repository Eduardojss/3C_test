<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum'
])->group( function () {
    Route::resource('/products', ProductController::class)->names('products.resource')->except(['index']);

    Route::get('/user', [UserController::class, 'getUserInfo'])->name('user.info');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');