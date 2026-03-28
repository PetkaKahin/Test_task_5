<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\DestroyTaskRequest;
use App\Http\Requests\Tasks\ShowTaskRequest;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Http\Resources\api\TaskResource;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService,
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        return TaskResource::collection($this->taskService->index($user));
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        /** @var User $user */
        $user = $request->user();

        return new TaskResource($this->taskService->store($request, $user));
    }

    public function show(ShowTaskRequest $request, Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        return new TaskResource($this->taskService->update($request, $task));
    }

    public function destroy(DestroyTaskRequest $request, Task $task): JsonResponse
    {
        $this->taskService->destroy($task);

        return response()->json(null, 204);
    }
}