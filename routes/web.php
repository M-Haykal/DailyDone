<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'viewLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'viewRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([AdminMiddleware::class, 'auth'])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});

