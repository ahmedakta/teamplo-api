<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\ContentController as FrontContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContentCreatorController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DepartmentController;

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
    // ******* Projects Comments  Routes Sections ************
    Route::post('/project/{slug}/comment/save' , [CommentController::class , 'save']); // TODO 

    
    // ******************* Contents Routes Sections ***********************
    Route::get('/content-creator/dashboard' , [ContentCreatorController::class , 'index']);
    Route::get('/contents' , [ContentController::class , 'index']);
    Route::delete('/content/{slug}/delete' , [ContentController::class , 'destroy']);
    Route::get('/content/{slug}' , [ContentController::class , 'view']);



    // ******************* Dashboard ***********************
    Route::get('/dashboard' , [DashboardController::class , 'index']);
});

    // ******************* FRONTEND FORMS ***********************
    // _________ Home Page ______ 
    Route::get('/' , [FrontContentController::class , 'blogs' ]);
    // _________ Contact __________
    Route::post('/contact-us' , [UserController::class , 'contactUs']);

    // __________ BLOGS ______________
    Route::get('/blogs' , [FrontContentController::class , 'blogs' ]);
    Route::get('/blogs/{slug}' , [FrontContentController::class , 'view' ]);

    
// Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
//     // Admin-only routes
// });

// Route::middleware(['auth:sanctum', 'permission:edit-posts'])->group(function () {
//     // Routes that require specific permissions
// });
