<?php

namespace App\Domain\Finance\Expense\DTOs;

class IndexExpenseDTO {
    public function __construct(
        public readonly ?string $type,
        public readonly ?float $minValue,
        public readonly ?float $maxValue,
        public readonly ?string $category,
        public readonly ?bool $hasInstallments,
        public readonly ?string $startDate,
        public readonly ?string $endDate
    ) {}

    public static function fromRequest(array $data): IndexExpenseDTO {
        return new self(
            type: $data["type"] ?? null,
            minValue: $data["min_value"] ?? null,
            maxValue: $data["max_value"] ?? null,
            category: $data["category"] ?? null,
            hasInstallments: $data["has_installments"] ?? null,
            startDate: $data["start_date"] ?? null,
            endDate: $data["end_date"] ?? null,
        );
    }
}