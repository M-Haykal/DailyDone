<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\ProjectController;
use App\Http\Controllers\User\TaskController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

Route::get('/', function () {
    return view('start');
})->name('home');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'viewLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'viewRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', UserMiddleware::class])->group(function () {
    Route::get('user', [UsersController::class, 'index'])->name('user.dashboard');
    Route::post('user/create-project', [ProjectController::class, 'store'])->name('user.project.store');
    Route::get('user/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('/projects/{id}/share', [ProjectController::class, 'share'])->middleware('auth');
    Route::get('/projects/join/{token}', [ProjectController::class, 'joinProject'])->name('projects.join');
    Route::get('/projects/access/{token}', [ProjectController::class, 'accessProject'])->name('projects.access');
    Route::get('user/tasklist', [TaskController::class, 'index'])->name('user.tasklist.index');
    Route::post('user/tasklist/store', [TaskController::class, 'store'])->name('user.tasklist.store');
    Route::post('user/tasklist/{id}/update-status', [TaskController::class, 'updateStatus'])->name('tasklist.updateStatus');
});

Route::get('/mail/send', function () {
    $data = [
        'subject' => 'Testing Kirim Email',
        'title' => 'Testing Kirim Email',
        'body' => 'Ini adalah email uji coba dari Tutorial Laravel: Send Email Via SMTP GMAIL @ qadrLabs.com'
    ];

    Mail::to('haykalmuhammad456@gmail.com')->send(new SendEmail($data));

});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
