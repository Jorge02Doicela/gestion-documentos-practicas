{{-- resources/views/documentos/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h2 class="text-2xl mb-4 text-gray-800 dark:text-gray-200">Editar Documento</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Nombre del Documento:</label>
            <input
                id="nombre"
                type="text"
                name="nombre"
                value="{{ old('nombre', $documento->nombre) }}"
                class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                required
            >
        </div>

        <div class="mb-4">
            <label for="archivo" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">
                Reemplazar Archivo (opcional):
            </label>
            @if($documento->archivo)
                <p class="text-sm text-gray-500 mb-2">
                    Archivo actual: <a href="{{ asset('storage/' . $documento->archivo) }}" target="_blank" class="text-blue-500 underline">Ver archivo</a>
                </p>
            @endif
            <input
                id="archivo"
                type="file"
                name="archivo"
                accept=".pdf,.doc,.docx"
                class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
        </div>

        <div class="mb-4">
            <label for="estado" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Estado del Documento:</label>
            <select
                id="estado"
                name="estado"
                class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                required
            >
                <option value="pendiente" {{ old('estado', $documento->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="revisado_por_tutor" {{ old('estado', $documento->estado) == 'revisado_por_tutor' ? 'selected' : '' }}>Revisado por Tutor</option>
                <option value="aprobado" {{ old('estado', $documento->estado) == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                <option value="rechazado" {{ old('estado', $documento->estado) == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
            </select>
        </div>

        <div class="mb-6">
            <label for="comentarios" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Comentarios (opcional):</label>
            <textarea
                id="comentarios"
                name="comentarios"
                rows="4"
                class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Añade comentarios sobre el documento..."
            >{{ old('comentarios', $documento->comentarios) }}</textarea>
        </div>

        <div class="flex gap-4">
            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors duration-200"
            >
                Actualizar
            </button>

            <a href="{{ route('documentos.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition-colors duration-200">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
