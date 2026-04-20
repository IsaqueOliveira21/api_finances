<?php

namespace Database\Factories;

use App\Domain\Finance\Expense\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'description' => fake()->sentence(),
            'type' => 'unique',
            'total_amount' => fake()->randomFloat(2, 10, 5000),
            'category' => 'Others',
            'first_due_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'installment_count' => 0,
        ];
    }

    public function installment(): static {
        return $this->state(fn () => [
            'type' => 'installment',
            'installment_count' => fake()->numberBetween(2, 12),
        ]);
    }
}