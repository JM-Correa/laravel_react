@extends('layouts.app')

@section('content')
<main class="mx-auto w-full max-w-md p-4 sm:p-6">
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <div class="mb-5">
            <h1 class="text-lg font-semibold tracking-tight">Editar tarea</h1>
            <p class="text-sm text-gray-500">Modifica los datos de la tarea.</p>
        </div>

        <form action="{{ route('tasks.update', $task->idtask) }}" method="POST">
            @method('PUT')
            @include('tasks._form')
        </form>
    </div>
</main>
@endsection