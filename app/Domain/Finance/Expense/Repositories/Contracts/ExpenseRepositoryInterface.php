<?php

namespace App\Domain\Finance\Expense\Repositories\Contracts;

use App\Domain\Finance\Expense\DTOs\IndexExpenseDTO;
use App\Domain\Finance\Expense\DTOs\StoreExpenseDTO;
use App\Domain\Finance\Expense\Models\Expense;
use Illuminate\Pagination\LengthAwarePaginator;

interface ExpenseRepositoryInterface {
    public function index(IndexExpenseDTO $dto): LengthAwarePaginator;
    public function store(array $data): Expense;
    public function update(Expense $expense, array $data): Expense;
    public function destroy(Expense $expense): void;
}
