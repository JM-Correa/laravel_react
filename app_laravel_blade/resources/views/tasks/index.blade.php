@extends('layouts.app')

@section('content')
<main class="mx-auto w-full max-w-2xl p-4 sm:p-6">

    {{-- Alerta Flash (Equivalente a toast.success de Sonner) --}}
    @if (session('success'))
        <div class="mb-6 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-900">✕</button>
        </div>
    @endif

    {{-- Header --}}
    <header class="mb-6 flex items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Mis tareas</h1>
            <p class="text-sm text-gray-500">
                {{ $pendientes }} {{ $pendientes === 1 ? 'pendiente' : 'pendientes' }}
            </p>
        </div>

        <a href="{{ route('tasks.create') }}"
           class="inline-flex h-10 items-center justify-center gap-2 rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800">
            <span class="text-base leading-none">+</span>
            <span class="hidden sm:inline">Nueva tarea</span>
        </a>
    </header>

    {{-- Lista o estado vacío --}}
    @if ($tasks->isEmpty())
        <div class="flex flex-col items-center gap-2 rounded-lg border border-dashed bg-white py-16 text-center text-gray-500">
            <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <p class="text-sm">No hay tareas todavía</p>
        </div>
    @else
        <ul class="space-y-3">
            @foreach ($tasks as $task)
                <li>
                    <div class="flex items-start gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                        
                        {{-- Checkbox para marcar/desmarcar --}}
                        <form action="{{ route('tasks.update', $task->idtask) }}" method="POST" class="mt-1">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="toggle_estatus" value="1">
                            <input
                                type="checkbox"
                                onchange="this.form.submit()"
                                {{ $task->estatus ? 'checked' : '' }}
                                aria-label="Marcar como completada"
                                class="h-4 w-4 cursor-pointer rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                            >
                        </form>

                        {{-- Nombre y Detalle --}}
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-medium {{ $task->estatus ? 'text-gray-400 line-through' : 'text-gray-900' }}">
                                {{ $task->nombre }}
                            </p>
                            <p class="line-clamp-2 text-sm text-gray-500">
                                {{ $task->detalle }}
                            </p>
                        </div>

                        {{-- Botones Editar y Eliminar --}}
                        <div class="flex shrink-0 gap-1">
                            <a href="{{ route('tasks.edit', $task->idtask) }}"
                               aria-label="Editar tarea"
                               title="Editar"
                               class="inline-flex h-9 w-9 items-center justify-center rounded-md text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>

                            <form action="{{ route('tasks.destroy', $task->idtask) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        aria-label="Eliminar tarea"
                                        title="Eliminar"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-md text-red-600 transition hover:bg-red-50">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>
                </li>
            @endforeach
        </ul>
    @endif

</main>
@endsection