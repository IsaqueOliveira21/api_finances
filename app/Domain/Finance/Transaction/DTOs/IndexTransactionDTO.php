<?php

namespace App\Domain\Finance\Transaction\DTOs;

class IndexTransactionDTO {
    public function __construct(
        public readonly ?string $type,
        public readonly ?float $min_amount,
        public readonly ?float $max_amount,
        public readonly ?string $start_date,
        public readonly ?string $end_date,
    ) {}

    public static function fromRequest(array $data): self {
        return new self(
            type: $data["type"] ?? null,
            min_amount: $data["min_amount"] ?? null,
            max_amount: $data["max_amount"] ?? null,
            start_date: $data["start_date"] ?? null,
            end_date: $data["end_date"] ?? null,
        );
    }
}