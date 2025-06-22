<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');


Route::get('/login', [LoginController::class, 'show'])->name('login');

Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5.1')->name('login.store');

Route::get('register', [RegisterController::class, 'show'])->name('register');

Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:5.1')->name('register.store');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

