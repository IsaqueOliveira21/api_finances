<?php

namespace Database\Seeders;

use App\Domain\Finance\Expense\Models\Expense;
use App\Domain\Finance\Expense\Services\ExpenseInstallmentService;
use App\Domain\Finance\Expense\Services\ExpenseService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Expense::factory(10)->create(['user_id' => 1]);
        $expenseInstallments = Expense::factory(10)->installment()->create(['user_id' => 1]);
        $service = app(ExpenseInstallmentService::class);
        foreach($expenseInstallments as $expense) {
            $service->store($expense);
        }
    }
}