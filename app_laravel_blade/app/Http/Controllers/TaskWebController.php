<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskWebController extends Controller
{
    // GET /tasks (Reemplaza la carga inicial de Task.jsx)
    public function index(Request $request): View
    {
        $tasks = Task::query()
            ->when($request->filled('estatus'), fn ($q) =>
                $q->where('estatus', $request->integer('estatus')))
            ->when($request->filled('search'), fn ($q) =>
                $q->where('nombre', 'like', '%' . $request->string('search') . '%'))
            ->orderByDesc('idtask')
            ->get();

        $pendientes = $tasks->where('estatus', 0)->count();

        return view('tasks.index', compact('tasks', 'pendientes'));
    }

    // GET /tasks/create (Muestra la vista con el formulario vacío)
    public function create(): View
    {
        return view('tasks.create');
    }

    // POST /tasks (Reutiliza tu StoreTaskRequest)
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        Task::create($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tarea creada');
    }

    // GET /tasks/{task}/edit (Muestra la vista de edición con la tarea)
    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    // PUT /tasks/{task} (Reutiliza tu UpdateTaskRequest)
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        // Si solo se marcó/desmarcó el checkbox, regresamos sin mostrar alerta verde
        if ($request->has('only_estatus')) {
            return redirect()->route('tasks.index');
        }

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tarea actualizada');
    }

    // DELETE /tasks/{task}
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tarea eliminada');
    }
}