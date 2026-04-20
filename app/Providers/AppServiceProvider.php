<?php

namespace App\Providers;

use App\Domain\Finance\Expense\Repositories\Contracts\ExpenseInstallmentRepositoryInterface;
use App\Domain\Finance\Expense\Repositories\Contracts\ExpenseRepositoryInterface;
use App\Domain\Finance\Expense\Repositories\Eloquent\ExpenseInstallmentRepository;
use App\Domain\Finance\Expense\Repositories\Eloquent\ExpenseRepository;
use App\Domain\Finance\Transaction\Repositories\Contracts\TransactionRepositoryInterface;
use App\Domain\Finance\Transaction\Repositories\Eloquent\TransactionRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
        $this->app->bind(ExpenseInstallmentRepositoryInterface::class, ExpenseInstallmentRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function(Request $request) {
            // Limita por ID do usuário autenticado ou por IP para visitantes
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip);
        });
    }
}
