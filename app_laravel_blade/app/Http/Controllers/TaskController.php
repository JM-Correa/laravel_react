<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    // GET /api/tasks?search=texto&estatus=1
    public function index(Request $request): JsonResponse
    {
        $tasks = Task::query()
            ->when($request->filled('estatus'), fn ($q) =>
                $q->where('estatus', $request->integer('estatus')))
            ->when($request->filled('search'), fn ($q) =>
                $q->where('nombre', 'like', '%' . $request->string('search') . '%'))
            ->orderByDesc('idtask')
            ->get();

        return response()->json($tasks);
    }

    // POST /api/tasks
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());

        return response()->json($task, 201);
    }

    // GET /api/tasks/{task}
    public function show(Task $task): JsonResponse
    {
        return response()->json($task);
    }

    // PUT /api/tasks/{task}
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task->update($request->validated());

        return response()->json($task);
    }

    // DELETE /api/tasks/{task}
    public function destroy(Task $task): Response
    {
        $task->delete();

        return response()->noContent();
    }
}