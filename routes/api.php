<?php

use App\Http\Controllers\Finance\Expense\ExpenseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [UserController::class, 'me']);
        Route::delete('/logout', [UserController::class, 'logout']);

        Route::prefix('/finances')->group(function() {
            Route::apiResource('expenses', ExpenseController::class);
        });
    });
});
