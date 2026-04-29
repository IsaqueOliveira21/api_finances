<?php

namespace App\Domain\Finance\Transaction\Repositories\Contracts;

use App\Domain\Finance\Transaction\DTOs\IndexTransactionDTO;
use App\Domain\Finance\Transaction\DTOs\StoreTransactionDTO;
use App\Domain\Finance\Transaction\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;

interface TransactionRepositoryInterface {
    public function index(IndexTransactionDTO $dto): LengthAwarePaginator;
    public function store(StoreTransactionDTO $dto): Transaction;
    public function getUserWalletBalance(): float;
}
