<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::post('/export', [\App\Http\Controllers\ExportController::class, 'export']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::resource('users', UserController::class);
    Route::resource('drives', DrivesController::class);
    Route::get('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
    Route::get('/change_password', [\App\Http\Controllers\UserController::class, 'changePassword'])->name('change_password');
    Route::post('/change_password', [\App\Http\Controllers\UserController::class, 'saveNewPassword']);
});
