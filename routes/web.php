<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\StudyController;
use Illuminate\Support\Facades\Route;

// Welcome

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

// Dashboard

Route::get('/dashboard', function () {
    $decks = auth()->user()->decks()->get();
    return view('dashboard', compact('decks'));
})->middleware(['auth'])->name('dashboard');

// Auth

Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');

Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5.1')->name('login.store');

Route::get('/register', [RegisterController::class, 'show'])->middleware('guest')->name('register');

Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:5.1')->name('register.store');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Decks

Route::get('/decks/create', [DeckController::class, 'show'])->name('decks.show');

Route::post('/decks/create', [DeckController::class, 'store'])->name('decks.store');

// Cards

Route::get('/cards/create', [CardController::class, 'show'])->name('cards.show');

Route::post('/cards/create', [CardController::class, 'store'])->name('cards.store');

// Study

Route::post('/study', [StudyController::class, 'start'])->name('study');
