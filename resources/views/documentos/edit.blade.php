@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h2 class="text-2xl mb-4 text-gray-800 dark:text-gray-200">Editar Documento</h2>

    <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Nombre del Documento:</label>
            <input type="text" name="nombre" value="{{ old('nombre', $documento->nombre) }}"
                   class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Reemplazar Archivo (opcional):</label>
            <input type="file" name="archivo" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Actualizar
        </button>
    </form>
</div>
@endsection
