<?php

use App\Domain\Finance\Expense\Models\ExpenseInstallment;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it("Mark an Expense Installment as paid updating the 'paid_at' column", function() {
    $user = User::factory()->create();

    $expense = $this->actingAs($user, 'sanctum')->postJson("/api/v1/finances/expenses", [
        "description" => "Notebook Gamer",
        "type" => "installment",
        "total_amount" => 5000,
        "category" => "Technology",
        "first_due_date" => Carbon::now()->format('Y-m-d'),
        "installment_count" => 10,
    ]);

    $expense->assertStatus(201);

    $this->assertDatabaseHas("expenses", [
        'id' => $expense->json('data.id'),
    ]);

    $installments = ExpenseInstallment::where('expense_id', $expense->json("data.id"))->whereNull("paid_at")->get();
    expect($installments->count())->toBe(10);

    $response = $this->actingAs($user, 'sanctum')->putJson("/api/v1/finances/expenses/{$expense->json('data.id')}/installments/pay/{$installments[0]->id}");
    $response->assertStatus(200);

    $this->assertDatabaseHas("expenses_installments", [
        'id' => $installments[0]->id,
        'paid_at' => $response->json('data.paid_at'),
    ]);
});
