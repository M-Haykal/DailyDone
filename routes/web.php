<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\User\ProjectController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\backgroundProjectController;
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
    Route::get('user/profile', [UsersController::class, 'profile'])->name('user.profile');
    Route::get('user/deadline', [UsersController::class, 'deadline'])->name('user.deadline');
    Route::get('user/projects', [UsersController::class, 'project'])->name('user.project');
    Route::get('user/archive', [UsersController::class, 'archive'])->name('user.archive');
    Route::get('user/edit-profile', [UsersController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('user/update-profile', [UsersController::class, 'updateProfile'])->name('user.profile.update');    
    Route::post('user/create-project', [ProjectController::class, 'store'])->name('user.project.store');
    Route::get('user/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('/projects/{id}/share', [ProjectController::class, 'share'])->middleware('auth');
    Route::get('/projects/join/{token}', [ProjectController::class, 'joinProject'])->name('projects.join');
    Route::get('/projects/access/{token}', [ProjectController::class, 'accessProject'])->name('projects.access');
    Route::get('user/tasklist', [TaskController::class, 'index'])->name('user.tasklist.index');
    Route::post('user/tasklist/store', [TaskController::class, 'store'])->name('user.tasklist.store');
    Route::post('user/tasklist/{id}/update-status', [TaskController::class, 'updateStatus'])->name('tasklist.updateStatus');
    Route::delete('/user/tasklist/{id}', [TaskListController::class, 'destroy'])->name('user.tasklist.destroy');
    Route::get('user/detailList/{id}', [TaskController::class, 'detailList'])->name('user.detailList');
    Route::post('user/projects/{id}/delete', [ProjectController::class, 'deleteProject'])->name('projects.delete');
    Route::delete('/user/tasklist/{id}', [TaskController::class, 'destroy'])->name('user.tasklist.destroy');
    Route::put('user/project/{idProject}/tasklist/{idTaskList}/edit', [TaskController::class, 'edit'])->name('user.tasklist.edit');
    Route::get('user/project/{idProject}/tasklist/{idTaskList}/edit', [TaskController::class, 'viewEdit'])->name('user.tasklist.viewEdit');
    Route::get('user/project/{idProject}/tasklist/{idTaskList}', [TaskController::class, 'detailList'])->name('user.detailList');
    Route::get('user/comments', [CommentController::class, 'index'])->name('user.comments.index');
    Route::post('user/comments/store', [CommentController::class, 'store'])->name('user.comments.store');
    Route::get('user/comments/{comment}', [CommentController::class, 'show'])->name('user.comments.show');
    Route::put('user/comments/{comment}/edit', [CommentController::class, 'update'])->name('user.comments.update');
    Route::delete('user/comments/{comment}', [CommentController::class, 'destroy'])->name('user.comments.destroy');
    Route::get('user/background-projects', [backgroundProjectController::class, 'index'])->name('user.backgroundProjects.index');
    Route::post('user/background-projects/store', [backgroundProjectController::class, 'store'])->name('user.backgroundProjects.store');
});
