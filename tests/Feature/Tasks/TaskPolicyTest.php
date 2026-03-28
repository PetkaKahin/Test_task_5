<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->owner = User::factory()->create();
    $this->otherUser = User::factory()->create();
    $this->task = Task::factory()->create(['user_id' => $this->owner->id]);
    $this->otherToken = $this->otherUser->createToken('api')->plainTextToken;
});

test('user cannot view another users task', function () {
    $response = $this->withHeader('Authorization', "Bearer $this->otherToken")
        ->getJson("/api/tasks/{$this->task->id}");

    $response->assertForbidden();
});

test('user cannot update another users task', function () {
    $response = $this->withHeader('Authorization', "Bearer $this->otherToken")
        ->putJson("/api/tasks/{$this->task->id}", [
            'title' => 'Hacked',
        ]);

    $response->assertForbidden();
});

test('user cannot delete another users task', function () {
    $response = $this->withHeader('Authorization', "Bearer $this->otherToken")
        ->deleteJson("/api/tasks/{$this->task->id}");

    $response->assertForbidden();
});

test('owner can access own task', function () {
    $ownerToken = $this->owner->createToken('api')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer $ownerToken")
        ->getJson("/api/tasks/{$this->task->id}");

    $response->assertOk();
});