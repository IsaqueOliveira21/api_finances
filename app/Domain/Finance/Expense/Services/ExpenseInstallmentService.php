<?php

namespace App\Domain\Finance\Expense\Services;

use App\Domain\Finance\Expense\DTOs\StoreExpenseInstallmentDTO;
use App\Domain\Finance\Expense\Models\Expense;
use App\Domain\Finance\Expense\Models\ExpenseInstallment;
use App\Domain\Finance\Expense\Repositories\Contracts\ExpenseInstallmentRepositoryInterface;
use App\Domain\Finance\Transaction\DTOs\StoreTransactionDTO;
use App\Domain\Finance\Transaction\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ExpenseInstallmentService {

    public function __construct(
        private ExpenseInstallmentRepositoryInterface $expenseInstallmentRepository,
        private TransactionService $transactionService,
    ) {}

    public function index(Expense $expense): Collection {
        $installments = $this->expenseInstallmentRepository->index($expense);
        return $installments;
    }

    public function store(Expense $expense): Expense {
        $amountInstallment = $expense->total_amount / $expense->installment_count;
        for($i = 0; $i < $expense->installment_count; $i++) {
            $date = Carbon::parse($expense->first_due_date)->addMonths($i)->format("Y-m-d");
            $this->expenseInstallmentRepository->store(new StoreExpenseInstallmentDTO(
                expenseId: $expense->id,
                installmentNumber: $i + 1,
                amount: $amountInstallment,
                dueDate: $date,
                paidAt: null,
            ));
        }
        return $expense;
    }

    public function pay(ExpenseInstallment $expenseInstallment): ExpenseInstallment {
        $this->expenseInstallmentRepository->pay($expenseInstallment);
        $this->transactionService->store(StoreTransactionDTO::fromRequest([
            "expense_id" => $expenseInstallment->expense->id,
            "type" => "outcome",
            "amount" => $expenseInstallment->amount,
            "description" => "Installment Payment ({$expenseInstallment->expense->description}): Pagamento da parcela {$expenseInstallment->installment_number} ({$expenseInstallment->installment_number}/{$expenseInstallment->expense->installment_count})",
        ]));
        return $expenseInstallment;
    }
}
