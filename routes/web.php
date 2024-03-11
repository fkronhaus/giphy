<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Auth\LoginController;


 

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
/*
Route::get('/', function () {

    return view('home');
});
*/

Route::get('/', [LoginController::class, 'home'])->name('home');

Route::get('/google-login', [GoogleController::class, 'login'])->name('googleLogin');

Route::get('/google-callback', [GoogleController::class, 'callback']);




