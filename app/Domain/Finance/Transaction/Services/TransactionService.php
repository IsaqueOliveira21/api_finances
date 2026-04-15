<?php

namespace App\Domain\Finance\Transaction\Services;

use App\Domain\Finance\Transaction\DTOs\IndexTransactionDTO;
use App\Domain\Finance\Transaction\DTOs\StoreTransactionDTO;
use App\Domain\Finance\Transaction\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionService {
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
    ) {}

    public function index(IndexTransactionDTO $dto) {
        return $this->transactionRepository->index($dto);
    }

    public function store(StoreTransactionDTO $dto) {
        return $this->transactionRepository->store($dto);
    }
}