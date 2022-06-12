<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FixtureController;
use \App\Http\Controllers\GameController;
use \App\Http\Controllers\TeamController;

Route::controller(TeamController::class)->prefix('teams')->group(function () {
    Route::get('fetch-all', 'fetchAll');
    Route::get('fetch-all-and-ordered', 'fetchAllAndOrdered');
});

Route::apiResource('fixtures', FixtureController::class)->only('update');;
Route::controller(FixtureController::class)->prefix('fixtures')->group(function () {
    Route::get('fetch-all', 'fetchAll');
    Route::get('fetch-counted-fixtures-week', 'fetchCountedFixturesWeek');
    Route::get('fetch-by-week/{number_of_week}', 'fetchByWeek');
    Route::get('fetch-group-by-week', 'fetchGroupByWeek');
    Route::get('prepare', 'prepare');
    Route::get('refresh', 'refresh');
});

Route::controller(GameController::class)->prefix('games')->group(function () {
    Route::get('complete-game', 'completeGame');
    Route::get('play-game-by-week/{number_of_week}', 'playGameByWeek');
    Route::get('predict', 'predict');
});
