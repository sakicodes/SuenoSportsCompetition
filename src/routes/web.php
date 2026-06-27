<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\RoundController;

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
});

require __DIR__.'/auth.php';
