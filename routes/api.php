<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DepartmentController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logged-in-user' , [UserController::class , 'loggedInUser']);


    
    // ***************** tasks routes section ******************************
    Route::get('/department/{department_slug}/{project_slug}/tasks' , [TaskController::class , 'index']);
    Route::post('/tasks/delete/{id}' , [TaskController::class , 'delete']);
    
    // ****************** Department Routes *****************************
    Route::get('/department/users/{id}' , [ProjectController::class , 'users']);
    Route::get('/departments' , [DepartmentController::class , 'index']);
    Route::get('/department/{slug}' , [DepartmentController::class , 'view']);
    
    
    // ******************* Projects Routes Sections ***********************
    Route::put('/project/update' , [ProjectController::class , 'update']);
    Route::post('/project/save' , [ProjectController::class , 'save']);
    Route::get('/project/{slug}' , [ProjectController::class , 'view']); // TODO 
    Route::delete('/project/delete/{id}', [ProjectController::class, 'destroy']);
    // assing user to project
    Route::post('/project/assign-user' , [ProjectController::class , 'userAssignment']);
    Route::get('/projects' , [ProjectController::class , 'index']);
    Route::get('/projects/create' , [ProjectController::class , 'create']);
    
    // ******************* Contents Routes Sections ***********************
    Route::get('/contents' , [ContentController::class , 'index']);
    Route::delete('/content/:slug/delete' , [ContentController::class , 'destroy']);



    // ******************* Dashboard ***********************
    Route::get('/dashboard' , [DashboardController::class , 'index']);
});



// Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
//     // Admin-only routes
// });

// Route::middleware(['auth:sanctum', 'permission:edit-posts'])->group(function () {
//     // Routes that require specific permissions
// });
