<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('list the users transactions in database with filters or not', function () {
    $user = User::factory()->create();

    $response = $this
        ->withoutExceptionHandling()
        ->actingAs($user, 'sanctum')
        ->getJson('/api/v1/transactions/');
        //->dump();

    $response->assertStatus(200);
});
