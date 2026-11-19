@csrf

<div class="space-y-4">
    {{-- Campo Nombre --}}
    <div class="space-y-2">
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            maxlength="45"
            placeholder="Ej. Estudiar Laravel"
            value="{{ old('nombre', $task->nombre ?? '') }}"
            class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
        >
        @error('nombre')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Campo Detalle --}}
    <div class="space-y-2">
        <label for="detalle" class="block text-sm font-medium text-gray-700">Detalle</label>
        <textarea
            id="detalle"
            name="detalle"
            rows="4"
            placeholder="Describe la tarea"
            class="flex w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
        >{{ old('detalle', $task->detalle ?? '') }}</textarea>
        @error('detalle')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Botones --}}
    <div class="flex flex-col-reverse gap-2 pt-2 sm:flex-row sm:justify-end">
        <a href="{{ route('tasks.index') }}"
           class="inline-flex h-10 items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Cancelar
        </a>
        <button type="submit"
                class="inline-flex h-10 items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
            Guardar
        </button>
    </div>
</div>