<?php

namespace App\Domain\Finance\Expense\Repositories\Contracts;

use App\Domain\Finance\Expense\DTOs\StoreExpenseInstallmentDTO;
use App\Domain\Finance\Expense\Models\Expense;
use App\Domain\Finance\Expense\Models\ExpenseInstallment;
use Illuminate\Support\Collection;

interface ExpenseInstallmentRepositoryInterface {
    public function index(Expense $expense): Collection;
    public function store(StoreExpenseInstallmentDTO $dto): ExpenseInstallment;
    public function pay(ExpenseInstallment $expenseInstallment): ExpenseInstallment;
}