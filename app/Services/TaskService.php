<?php

namespace App\Services;

use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    /**
     * @return LengthAwarePaginator<int, Task>
     */
    public function index(User $user): LengthAwarePaginator
    {
        return Task::query()
            ->where('user_id', $user->id)
            ->paginate(50);
    }

    public function store(StoreTaskRequest $request, User $user): Task
    {
        /** @var Task $task */
        $task = $user->tasks()->create($request->validated());

        return $task;
    }

    public function update(UpdateTaskRequest $request, Task $task): Task
    {
        $task->update($request->validated());

        return $task;
    }

    public function destroy(Task $task): void
    {
        $task->delete();
    }
}