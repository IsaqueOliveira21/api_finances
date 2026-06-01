<?php

use App\Domain\Finance\Expense\Models\ExpenseInstallment;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it("It creates an unique expense and deducts the balance from the user's wallet", function() {
    $user = User::factory()->create();

    $response = $this->actingAs($user, "sanctum")
        ->postJson("/api/v1/finances/expenses", [
            "description" => "Iphone 14 Pro Max Test",
            "type" => "unique",
            "total_amount" => 14000,
            "category" => "Technology",
            "first_due_date" => Carbon::now()->format('2026-06-01'),
            "installment_count" => 0,
        ]);
    $response->assertStatus(201);
    $this->assertDatabaseHas("expenses", [
        "description" => "Iphone 14 Pro Max Test",
        "total_amount" => 14000,
    ]);
    $this->assertDatabaseHas("transactions", [
        "description" => "Gasto: Iphone 14 Pro Max Test",
        "type" => "outcome",
        "amount" => 14000,
    ]);
});

it("It creates an installment expense and creates the installments in the expenses_installment's table", function() {
    $user = User::factory()->create();

    $response = $this->actingAs($user, "sanctum")
        ->postJson("/api/v1/finances/expenses", [
            "description" => "Playstation 5 pro Test",
            "type" => "installment",
            "total_amount" => 3500,
            "category" => "Technology",
            "first_due_date" => Carbon::now()->format('2026-06-01'),
            "installment_count" => 5,
        ]);
    $response->assertStatus(201);
    $this->assertDatabaseHas("expenses", [
        "description" => "Playstation 5 pro Test",
        "type" => "installment",
        "total_amount" => 3500,
        "installment_count" => 5,
    ]);

    $installmentCount = ExpenseInstallment::where('expense_id', $response->json("data.id"))->whereNull("paid_at")->count();
    expect($installmentCount)->toBe(5);
});
