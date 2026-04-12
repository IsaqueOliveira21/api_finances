<?php

namespace App\Providers;

use App\Domain\Finance\Expense\Repositories\Contracts\ExpenseInstallmentRepositoryInterface;
use App\Domain\Finance\Expense\Repositories\Contracts\ExpenseRepositoryInterface;
use App\Domain\Finance\Expense\Repositories\Eloquent\ExpenseInstallmentRepository;
use App\Domain\Finance\Expense\Repositories\Eloquent\ExpenseRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
