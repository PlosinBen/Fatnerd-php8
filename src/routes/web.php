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


Route::middleware(['guest'])->resource('login', \App\Http\Controllers\LoginController::class)->only('index', 'store');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Controller::class, 'index'])->name('index');

    Route::prefix('invest')->as('invest.')->group(function () {
        Route::resource('account', \App\Http\Controllers\InvestAccountController::class)->only('index', 'store');
        Route::resource('futures', \App\Http\Controllers\InvestFuturesController::class);
    });
});

