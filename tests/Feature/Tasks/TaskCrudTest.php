<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('api')->plainTextToken;
});

test('user can get list of own tasks', function () {
    Task::factory(3)->create(['user_id' => $this->user->id]);
    Task::factory(2)->create(); // чужие таски

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->getJson('/api/tasks');

    $response->assertOk()
        ->assertJsonCount(3, 'data');
});

test('user can create a task', function () {
    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->postJson('/api/tasks', [
            'title' => 'New Task',
            'description' => 'Task description',
            'status' => 'processing',
        ]);

    $response->assertCreated()
        ->assertJsonPath('data.title', 'New Task')
        ->assertJsonPath('data.user_id', $this->user->id);

    $this->assertDatabaseHas('tasks', [
        'title' => 'New Task',
        'user_id' => $this->user->id,
    ]);
});

test('user can view own task', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->getJson("/api/tasks/{$task->id}");

    $response->assertOk()
        ->assertJsonPath('data.id', $task->id);
});

test('user can update own task', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title',
        ]);

    $response->assertOk()
        ->assertJsonPath('data.title', 'Updated Title');
});

test('user can delete own task', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);

    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->deleteJson("/api/tasks/{$task->id}");

    $response->assertNoContent();

    $this->assertSoftDeleted('tasks', ['id' => $task->id]);
});

test('user cannot create task without required fields', function () {
    $response = $this->withHeader('Authorization', "Bearer $this->token")
        ->postJson('/api/tasks', []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['title', 'status']);
});

test('unauthenticated user cannot access tasks', function () {
    $this->getJson('/api/tasks')->assertUnauthorized();
    $this->postJson('/api/tasks', [])->assertUnauthorized();
});