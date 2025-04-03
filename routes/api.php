<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\Api\ProjectsController;
use App\Models\Project;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('jwt.auth')->group(function () {
    Route::get('/user/projects', [ProjectsController::class, 'getProjectByUserId']);
    Route::get('/user/project/{id}', [ProjectsController::class, 'getProjectById']);    
    Route::post('/user/create-project', [ProjectsController::class, 'store']);
    Route::put('/user/project/{id}/edit', [ProjectsController::class, 'update']);
});
