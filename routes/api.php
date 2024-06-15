<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logged-in-user' , [UserController::class , 'loggedInUser']);
    // tasks routes section 
    Route::get('/tasks' , [TaskController::class , 'index']);
    Route::post('/tasks/delete/{id}' , [TaskController::class , 'delete']);
    
    
    
    // projects routes section
    Route::put('/project/update' , [ProjectController::class , 'update']);
    Route::post('/project/save' , [ProjectController::class , 'save']);
    Route::get('/project/{id}' , [ProjectController::class , 'view']); // TODO 
    Route::delete('/project/delete/{id}', [ProjectController::class, 'destroy']);
    Route::get('/dashboard' , [DashboardController::class , 'index']);
});

Route::get('/projects' , [ProjectController::class , 'index']);
Route::get('/projects/create' , [ProjectController::class , 'create']);


// Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
//     // Admin-only routes
// });

// Route::middleware(['auth:sanctum', 'permission:edit-posts'])->group(function () {
//     // Routes that require specific permissions
// });
