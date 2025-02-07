<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\ProjectController;
use App\Http\Controllers\User\ListController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('start');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'viewLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'viewRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', UserMiddleware::class])->group(function () {
    Route::get('user', [UsersController::class, 'index'])->name('user.dashboard');
    Route::post('create-project', [ProjectController::class, 'create'])->name('user.project.create');
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('create-list', [ListController::class, 'create'])->name('user.tasklist.create');
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
