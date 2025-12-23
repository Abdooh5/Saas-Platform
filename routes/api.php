<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/health', fn () => response()->json([
    'message' => 'API is running',
    'status' => 'ok',
]));
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [Authcontroller::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/projects/trashed', [ProjectController::class, 'trashed']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);
    Route::put('/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);
    Route::post('/projects/{project}/restore', [ProjectController::class, 'restore']);
    Route::post('/users/create',[UserController::class,'store']);
    Route::get('/users',[UserController::class,'index']);
    Route::  post('/profile/change-password', [UserController::class, 'changePassword']);
    Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'role' => $request->user()->role,
            ]
        ]);
    });
    
});
