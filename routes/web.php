<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\PhraseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/dictionary', [DictionaryController::class, 'index'])->name('dictionary.index');
    Route::post('/dictionary/{word}/toggle', [DictionaryController::class, 'toggle'])->name('dictionary.toggle');
    Route::get('/phrases', [PhraseController::class, 'index'])->name('phrases.index');
    Route::post('/phrases/{phrase}/toggle', [PhraseController::class, 'toggle'])->name('phrases.toggle');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
