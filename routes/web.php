<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('groups.index')
        : redirect()->route('login');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('dashboard', '/groups')->name('dashboard');

    // Grupos / bolões
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::post('/groups', [GroupController::class, 'store'])->middleware('is_admin')->name('groups.store');
    Route::post('/groups/join', [GroupController::class, 'join'])->name('groups.join');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');

    // Palpites
    Route::post('/groups/{group}/games/{game}/predictions', [PredictionController::class, 'store'])
        ->name('predictions.store');

    // Participantes
    Route::get('/groups/{group}/participants', [GroupController::class, 'participants'])->name('groups.participants');

    // Ranking
    Route::get('/groups/{group}/ranking', [RankingController::class, 'show'])->name('ranking.show');
});

require __DIR__.'/settings.php';
