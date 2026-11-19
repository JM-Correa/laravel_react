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
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'completed' => 'boolean',
    ]);

    Task::create($validated);

    return redirect()
        ->route('tasks.index')
        ->with('success', 'Tarea creada correctamente.');
}

    // GET /api/tasks/{task}
    public function show(Task $task): JsonResponse
    {
        return response()->json($task);
    }

    // PUT /api/tasks/{task}
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse|RedirectResponse
{
    $data = $request->validated();

    if ($request->has('estatus')) {
        $data['estatus'] = $request->boolean('estatus');
    }

    $task->update($data);

    if ($request->wantsJson()) {
        return response()->json($task);
    }

    return redirect()
        ->route('tasks.index')
        ->with('success', 'Tarea actualizada correctamente.');
}

    // DELETE /api/tasks/{task}
    public function destroy(Task $task): Response
    {
        $task->delete();

        return response()->noContent();
    }
}