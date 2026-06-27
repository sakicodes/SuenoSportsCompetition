<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\Player\LeaderboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', AdminMiddleware::class])
	->prefix('admin')
	->name('admin.')
	->group(function () {
	    // Team Management Route
	    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
	    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');

	    // Competition Management Route
	    Route::get('/competitions', [CompetitionController::class, 'index'])->name('competitions.index');
	    Route::post('/competitions', [CompetitionController::class, 'store'])->name('competitions.store');
	    Route::get('/competitions/{competition}', [CompetitionController::class, 'show'])->name('competitions.show');

	    // Route Management Route
	    Route::post('/competitions/{competition}/rounds', [RoundController::class, 'store'])->name('rounds.store');

	    // Match Management Route
	    Route::post('/competitions/{competition}/matches', [App\Http\Controllers\Admin\MatchController::class, 'store'])->name('matches.store');

	    // User Management Route
	    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
	    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
	    Route::post('/users/{user}/points', [App\Http\Controllers\Admin\UserController::class, 'adjustPoints'])->name('users.points');

	    // Match Resolution Routes
	    Route::post('/matches/{match}/resolve', [\App\Http\Controllers\Admin\MatchResolutionController::class, 'resolve'])->name('matches.resolve');
	    Route::post('/matches/{match}/cancel', [\App\Http\Controllers\Admin\MatchResolutionController::class, 'cancel'])->name('matches.cancel');
});

// ==========================================
// PLAYER ROUTES (Requires Auth, but NOT Admin)
// ==========================================
Route::middleware(['auth'])->prefix('play')->name('player.')->group(function () {
    
    Route::get('/competitions', [\App\Http\Controllers\Player\CompetitionController::class, 'index'])->name('competitions.index');
    Route::get('/competitions/{competition}', [\App\Http\Controllers\Player\CompetitionController::class, 'show'])->name('competitions.show');

    // Prediction Route
    Route::post('/matches/{match}/predictions', [\App\Http\Controllers\Player\PredictionController::class, 'store'])->name('predictions.store');

    //Leaderboard Route
    Route::get('/leaderboard', [\App\Http\Controllers\Player\LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::get('/leaderboard/{competition}', [\App\Http\Controllers\Player\LeaderboardController::class, 'competition'])->name('leaderboard.competition');
});

require __DIR__.'/auth.php';
