<?php

use App\Http\Controllers\api\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return 'pong';
});

Route::middleware('guest')->group(function () {
    Route::post('login');
    Route::post('register');
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});