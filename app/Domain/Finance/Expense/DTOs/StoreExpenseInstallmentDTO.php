<?php

namespace App\Domain\Finance\Expense\DTOs;

class StoreExpenseInstallmentDTO {

    public function __construct(
        public readonly int $expenseId,
        public readonly int $installmentNumber,
        public readonly float $amount,
        public readonly string $dueDate,
        public readonly ?string $paidAt,
    ) {}
}
