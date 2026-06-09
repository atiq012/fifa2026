<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/saveMyteam', [DashboardController::class, 'saveMyteam'])->middleware(['auth', 'verified'])->name('saveMyteam');

// prediction
Route::get('/predictions', [PredictionController::class, 'index'])->middleware(['auth', 'verified'])->name('predictions');
Route::post('/predictions-store', [PredictionController::class, 'store'])->middleware(['auth', 'verified'])->name('predictions.store');

// leaderboard
Route::get('/leaderboard', [DashboardController::class, 'leaderboard'])->middleware(['auth', 'verified'])->name('leaderboard');

// update result
Route::get('/update_result', [DashboardController::class, 'update_result'])->middleware(['auth', 'verified'])->name('update_result');
Route::post('/final/save-result', [DashboardController::class, 'update_result_store'])->middleware(['auth', 'verified'])->name('update_result_store');

// analytics
Route::get('/analytics', [DashboardController::class, 'analytics'])->middleware(['auth', 'verified'])->name('analytics');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
