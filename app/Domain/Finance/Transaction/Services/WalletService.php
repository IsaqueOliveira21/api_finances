<?php

namespace App\Domain\Finance\Transaction\Services;

use App\Domain\Finance\Transaction\Repositories\Contracts\TransactionRepositoryInterface;

class WalletService {

    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
    ) {}

    public function getUserWalletBalance(): float {
        return $this->transactionRepository->getUserWalletBalance() ?? 0;
    }
}
