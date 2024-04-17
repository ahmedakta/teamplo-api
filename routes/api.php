<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Api\UserController;


// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logged-in-user' , [UserController::class , 'loggedInUser']);
});
Route::get('/tasks' , [TaskController::class , 'index']);
Route::post('/tasks/delete/{id}' , [TaskController::class , 'delete']);

