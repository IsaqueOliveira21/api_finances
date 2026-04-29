<?php

namespace App\Domain\Finance\Transaction\Repositories\Eloquent;

use App\Domain\Finance\Transaction\DTOs\IndexTransactionDTO;
use App\Domain\Finance\Transaction\DTOs\StoreTransactionDTO;
use App\Domain\Finance\Transaction\Models\Transaction;
use App\Domain\Finance\Transaction\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TransactionRepository implements TransactionRepositoryInterface {

    public function __construct(
        private Transaction $transactionModel,
    ) {}

    public function index(IndexTransactionDTO $dto): LengthAwarePaginator {
        $user_id = Auth::user()->id;
        $transactions = $this->transactionModel
            ->where("user_id", $user_id)
            ->when($dto->type, function($q) use ($dto) {
                $q->where("type", $dto->type);
            })
            ->when($dto->min_amount, function($q) use ($dto) {
                $q->where("amount", ">=", $dto->min_amount);
            })
            ->when($dto->max_amount, function($q) use ($dto) {
                $q->where("amount", "<=", $dto->max_amount);
            })
            ->when($dto->start_date, function($q) use ($dto) {
                $q->where("created_at", ">=", $dto->start_date);
            })
            ->when($dto->end_date, function($q) use ($dto) {
                $q->where("created_at", "<=", $dto->end_date);
            })
            ->paginate(15);
        return $transactions;
    }

    public function store(StoreTransactionDTO $dto): Transaction {
        $user_id = Auth::user()->id;
        $transaction = $this->transactionModel->create([
            "user_id" => $user_id,
            "expense_id" => $dto->expense_id ?? null,
            "type" => $dto->type,
            "amount" => $dto->amount,
            "description" => $dto->description ?? null,
        ]);
        return $transaction;
    }

    public function getUserWalletBalance(): float {
        $user_id = Auth::user()->id;
        $balance = $this->transactionModel
            ->where('user_id', $user_id)
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) AS total")
            ->value('total');
        return $balance ?? 0;
    }
}