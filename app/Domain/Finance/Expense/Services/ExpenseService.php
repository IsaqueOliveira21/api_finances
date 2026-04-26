<?php

namespace App\Domain\Finance\Expense\Services;

use App\Domain\Finance\Expense\DTOs\IndexExpenseDTO;
use App\Domain\Finance\Expense\DTOs\StoreExpenseDTO;
use App\Domain\Finance\Expense\DTOs\UpdateExpenseDTO;
use App\Domain\Finance\Expense\Models\Expense;
use App\Domain\Finance\Expense\Repositories\Contracts\ExpenseRepositoryInterface;
use App\Domain\Finance\Transaction\DTOs\StoreTransactionDTO;
use App\Domain\Finance\Transaction\Services\TransactionService;
use App\Exceptions\InvalidExpenseTypeException;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseService {

    public function __construct(
        private ExpenseRepositoryInterface $expenseRepository,
        private ExpenseInstallmentService $expenseInstallmentService,
        private TransactionService $transactionService,
    ) {}

    public function index(IndexExpenseDTO $dto): LengthAwarePaginator {
        $expenses = $this->expenseRepository->index($dto);
        return $expenses;
    }

    public function store(StoreExpenseDTO $dto): Expense {
        return DB::transaction(function() use ($dto) {
            $expense = $this->expenseRepository->store([
                'user_id' => Auth::id(),
                'description' => $dto->description,
                'type' => $dto->type,
                'total_amount' => $dto->totalAmount,
                'category' => $dto->category,
                'first_due_date' => $dto->firstDueDate,
                'installment_count' => $dto->installmentCount,
            ]);

            if ($expense->type !== "installment") {
                $this->transactionService->store(
                    StoreTransactionDTO::fromRequest([
                        "expense_id" => $expense->id,
                        "type" => "outcome",
                        "amount" => $expense->total_amount,
                        "description" => "Gasto: {$expense->description}",
                    ]),
                );
            }

            if($dto->installmentCount > 0 && $expense->type === "installment") {
                $this->expenseInstallmentService->store($expense);
            }

            return $expense;
        });
    }

    public function update(Expense $expense, UpdateExpenseDTO $dto): Expense {
        $expense = $this->expenseRepository->update($expense, [
            "description" => $dto->description,
            "total_amount" => $expense->type !== 'installment' ? $dto->totalAmount : $expense->total_amount,
            "category" => $dto->category,
            "first_due_date" => $expense->type !== 'installment' ? $dto->firstDueDate : $expense->first_due_date,
        ]);
        return $expense;
    }

    public function destroy(Expense $expense): void {
        DB::transaction(function() use ($expense) {
            $this->expenseRepository->destroy($expense);
        });
    }

    public function payRecurringExpense(Expense $expense) {
        if($expense->type !== 'recurring') throw new InvalidExpenseTypeException();
        $date = Carbon::now()->format('Y-m-d');
        $transaction = $this->transactionService->store(
            StoreTransactionDTO::fromRequest([
                "expense_id" => $expense->id,
                "type" => "outcome",
                "amount" => $expense->total_amount,
                "description" => "Pagamento recorrente: {$expense->description} ({$date})",
            ]),
        );
        return $transaction;
    }
}
