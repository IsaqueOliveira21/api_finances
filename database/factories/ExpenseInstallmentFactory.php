<?php

namespace Database\Factories;

use App\Domain\Finance\Expense\Models\Expense;
use App\Domain\Finance\Expense\Models\ExpenseInstallment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExpenseInstallment>
 */
class ExpenseInstallmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "expense_id" => Expense::factory(),
            "installment_number" => fake()->numberBetween(1, 12),
            "amount" => fake()->randomFloat(2, 10, 5000),
            "due_date" => fake()->dateTimeBetween('-1 year', 'now'),
            "paid_at" => null,
        ];
    }
}
