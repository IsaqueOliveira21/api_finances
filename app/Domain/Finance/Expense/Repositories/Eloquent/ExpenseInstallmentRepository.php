<?php

namespace App\Domain\Finance\Expense\Repositories\Eloquent;

use App\Domain\Finance\Expense\DTOs\StoreExpenseInstallmentDTO;
use App\Domain\Finance\Expense\Models\Expense;
use App\Domain\Finance\Expense\Models\ExpenseInstallment;
use App\Domain\Finance\Expense\Repositories\Contracts\ExpenseInstallmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ExpenseInstallmentRepository implements ExpenseInstallmentRepositoryInterface {

    public function __construct(
        private ExpenseInstallment $expenseInstallmentModel,
    ) {}

    public function index(Expense $expense): Collection {
        return $expense->installments;
    }

    public function store(StoreExpenseInstallmentDTO $dto): ExpenseInstallment {
        return $this->expenseInstallmentModel->create([
            "expense_id" => $dto->expenseId,
            "installment_number" => $dto->installmentNumber,
            "amount" => $dto->amount,
            "due_date" => $dto->dueDate,
            "paid_at" => $dto->paidAt,
        ]);
    }

    public function pay(ExpenseInstallment $expenseInstallment): ExpenseInstallment {
        $expenseInstallment->update([
            "paid_at" => Carbon::now()->format("Y-m-d H:i:s"),
        ]);
        return $expenseInstallment;
    }
}