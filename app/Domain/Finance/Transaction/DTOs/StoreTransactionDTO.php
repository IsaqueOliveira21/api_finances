<?php

namespace App\Domain\Finance\Transaction\DTOs;

class StoreTransactionDTO {
    public function __construct(
        public readonly ?int $expense_id,
        public readonly string $type,
        public readonly float $amount,
        public readonly ?string $description,
    ) {}

    public static function fromRequest(array $data): self {
        return new self(
            expense_id: $data["expense_id"] ?? null,
            type: $data["type"],
            amount: $data["amount"],
            description: $data["description"] ?? null,
        );
    }
}
