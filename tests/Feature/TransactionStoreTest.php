<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('Allow an user to add a value on his transactions to increase his balance', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->postJson('/api/v1/transactions/add-balance', [
            "expense_id" => null,
            "type" => "income",
            "amount" => 100.0,
            "description" => "Pagamento recebido por Claudio",
        ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('transactions', [
        'description' => 'Pagamento recebido por Claudio',
    ]);
});