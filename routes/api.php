<?php

use App\Http\Controllers\Finance\Expense\ExpenseController;
use App\Http\Controllers\Finance\Expense\ExpenseInstallmentController;
use App\Http\Controllers\Finance\Transaction\TransactionController;
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
            Route::post('/expenses/{expense}/recurring/payment', [ExpenseController::class, 'payRecurringExpense']);

            Route::prefix('/expenses/{expense}/installments')->controller(ExpenseInstallmentController::class)->group(function() {
                Route::get("/", "index");
                Route::put("/pay/{expenseInstallment}", "pay");
            });
        });

        Route::prefix('/transactions')->controller(TransactionController::class)->group(function() {
            Route::get('/', 'index');
            Route::get('/user/wallet/balance', 'getUserWalletBalance');
            Route::post('/add-balance', 'store');
        });
    });
});
