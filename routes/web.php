<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    return view('auth/login');
})->name('login');

Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
