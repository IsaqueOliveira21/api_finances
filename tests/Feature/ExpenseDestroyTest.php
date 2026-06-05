<?php

use App\Domain\Finance\Expense\Models\Expense;
use App\Domain\Finance\Transaction\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it("destroy a expense and the related transaction", function() {
    $user = User::factory()->create();

    $expense = Expense::factory()->create([
        'user_id' => $user->id,
    ]);

    /*
    $transaction = Transaction::factory()->create([
        'expense_id' => $expense->id,
        'type' => 'outcome',
    ]);
     */

    $response = $this->actingAs($user, 'sanctum')
        ->delete("/api/v1/finances/expenses/{$expense->id}");

    $response->assertStatus(204);

    $this->assertSoftDeleted('expenses', ['id' => $expense->id]);
    //$this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
});
