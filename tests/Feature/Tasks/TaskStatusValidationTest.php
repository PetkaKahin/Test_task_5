<?php

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('api')->plainTextToken;
});

test('user can create task with valid status', function (TaskStatus $status) {
    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->postJson('/api/tasks', [
            'title' => 'Test Task',
            'status' => $status->value,
        ]);

    $response->assertCreated()
        ->assertJsonPath('data.status', $status->value);
})->with(TaskStatus::cases());

test('user cannot create task with invalid status', function () {
    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->postJson('/api/tasks', [
            'title' => 'Test Task',
            'status' => 'invalid_status',
        ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['status']);
});

test('user can update task with valid status', function (TaskStatus $status) {
    $task = Task::factory()->create(['user_id' => $this->user->id]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->putJson("/api/tasks/{$task->id}", [
            'status' => $status->value,
        ]);

    $response->assertOk()
        ->assertJsonPath('data.status', $status->value);
})->with(TaskStatus::cases());

test('user cannot update task with invalid status', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->putJson("/api/tasks/{$task->id}", [
            'status' => 'invalid_status',
        ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['status']);
});