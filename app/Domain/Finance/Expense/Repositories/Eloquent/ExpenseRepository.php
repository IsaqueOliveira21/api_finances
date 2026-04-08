<?php

namespace App\Domain\Finance\Expense\Repositories\Eloquent;

use App\Domain\Finance\Expense\DTOs\IndexExpenseDTO;
use App\Domain\Finance\Expense\DTOs\StoreExpenseDTO;
use App\Domain\Finance\Expense\Models\Expense;
use App\Domain\Finance\Expense\Repositories\Contracts\ExpenseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ExpenseRepository implements ExpenseRepositoryInterface{

    public function __construct(
        private Expense $expenseModel,
    ) {}
    public function index(IndexExpenseDTO $dto): LengthAwarePaginator {
        $expenses = $this->expenseModel
            ->where('user_id', auth()->user()->id)
            ->when($dto->type, function ($query) use ($dto) {
                $query->where('type', $dto->type);
            })
            ->when($dto->minValue, function ($query) use ($dto) {
                $query->where('total_amount', '>=', $dto->minValue);
            })
            ->when($dto->maxValue, function ($query) use ($dto) {
                $query->where('total_amount', '<=', $dto->maxValue);
            })
            ->when($dto->category, function ($query) use ($dto) {
                $query->where('category', $dto->category);
            })
            ->when(!is_null($dto->hasInstallments), function ($query) use ($dto) {
                if ($dto->hasInstallments) {
                    $query->whereHas('installments');
                } else {
                    $query->whereDoesntHave('installments');
                }
            })
            ->when($dto->startDate, function ($query) use ($dto) {
                $query->whereDate('first_due_date', '>=', $dto->startDate);
            })
            ->when($dto->endDate, function ($query) use ($dto) {
                $query->whereDate('first_due_date', '<=', $dto->endDate);
            })
            ->paginate(15);
        return $expenses;
    }

    public function store(array $data): Expense {
        return Expense::create($data);
    }

    public function update(Expense $expense, array $data): Expense {
        $expense->update($data);
        return $expense;
    }

    public function destroy(Expense $expense): void {
        $expense->delete();
    }
}