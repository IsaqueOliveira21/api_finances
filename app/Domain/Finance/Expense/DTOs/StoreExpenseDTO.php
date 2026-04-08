<?php

namespace App\Domain\Finance\Expense\DTOs;

class StoreExpenseDTO {

    public function __construct(
        public readonly ?string $description,
        public readonly string $type,
        public readonly float $totalAmount,
        public readonly string $category,
        public readonly string $firstDueDate,
        public readonly int $installmentCount,
    ) {}

    public static function fromRequest(array $data): self {
        return new self(
            description: $data["description"] ?? null,
            type: $data["type"],
            totalAmount: $data["total_amount"],
            category: $data["category"],
            firstDueDate: $data["first_due_date"],
            installmentCount: $data["installment_count"],
        );
    }
}
