<?php

use App\Http\Controllers\Admin\GroupController as AdminGroupController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('dashboard', '/groups')->name('dashboard');

    // Grupos / bolões
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::post('/groups/join', [GroupController::class, 'join'])->name('groups.join');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');

    // Palpites
    Route::post('/groups/{group}/games/{game}/predictions', [PredictionController::class, 'store'])
        ->name('predictions.store');

    // Ranking
    Route::get('/groups/{group}/ranking', [RankingController::class, 'show'])->name('ranking.show');
});

// Admin
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/groups', [AdminGroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [AdminGroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [AdminGroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{group}', [AdminGroupController::class, 'show'])->name('groups.show');
    Route::delete('/groups/{group}', [AdminGroupController::class, 'destroy'])->name('groups.destroy');
});

require __DIR__.'/settings.php';
