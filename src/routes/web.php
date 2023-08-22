<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['guest'])->resource('login', \App\Http\Controllers\LoginController::class)
    ->only('index', 'store');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])->name('index');

    Route::prefix('invest')->as('invest.')->group(function () {
        Route::resource('account', \App\Http\Controllers\InvestAdmin\AccountController::class)
            ->only('index', 'store');
    });

    route::prefix('invest_admin')->as('invest_admin.')->group(function () {
        Route::resource('history', \App\Http\Controllers\InvestAdmin\HistoryController::class);
    });

    Route::prefix('statement')->as('statement.')->group(function () {

        Route::resource('futures', \App\Http\Controllers\InvestFuturesController::class)
            ->only('index', 'store', 'create');

        Route::post('/{}/distribute', [\App\Http\Controllers\StatementController::class, 'distribute'])
            ->name('distribute');
        Route::resource('/', \App\Http\Controllers\StatementController::class)
            ->only('index');
    });
});
