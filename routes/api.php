<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Controllers\GiphyController;
use App\Http\Controllers\StarredController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware([EnsureTokenIsValid::class])->group(function () {

    Route::get('/giphy/find', [GiphyController::class, 'find'])->name('giphy-find');

    Route::get('/giphy/get', [GiphyController::class, 'get'])->name('giphy-get');

    Route::get('/giphy/info/', [GiphyController::class, 'info'])->name('giphy-info');

    Route::post('/starred/add/', [StarredController::class, 'add'])->name('starred-add');
});


