{{-- resources/views/documentos/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h2 class="text-2xl mb-4 text-gray-800 dark:text-gray-200">Subir nuevo documento</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded">
            <h4 class="font-semibold mb-2">Por favor corrige los siguientes errores:</h4>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">
                Nombre del documento: <span class="text-red-500">*</span>
            </label>
            <input
                id="nombre"
                type="text"
                name="nombre"
                value="{{ old('nombre') }}"
                class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nombre') border-red-500 @enderror"
                placeholder="Ingresa el nombre del documento"
                required
            >
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="archivo" class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">
                Archivo (PDF, DOC, DOCX): <span class="text-red-500">*</span>
            </label>
            <input
                id="archivo"
                type="file"
                name="archivo"
                accept=".pdf,.doc,.docx"
                class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('archivo') border-red-500 @enderror"
                required
            >
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Máximo 2MB. Formatos permitidos: PDF, DOC, DOCX
            </p>
            @error('archivo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <strong>Nota:</strong> El documento se creará con estado "Pendiente" por defecto.
            </p>
        </div>

        <div class="flex gap-4">
            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition-colors duration-200 font-semibold"
            >
                Subir Documento
            </button>

            <a href="{{ route('documentos.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded transition-colors duration-200 font-semibold">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
// Mostrar el nombre del archivo seleccionado
document.getElementById('archivo').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        // Crear o actualizar el elemento que muestra el nombre del archivo
        let fileNameDisplay = document.getElementById('file-name-display');
        if (!fileNameDisplay) {
            fileNameDisplay = document.createElement('p');
            fileNameDisplay.id = 'file-name-display';
            fileNameDisplay.className = 'text-sm text-blue-600 dark:text-blue-400 mt-1';
            e.target.parentNode.appendChild(fileNameDisplay);
        }
        fileNameDisplay.textContent = `Archivo seleccionado: ${fileName}`;
    }
});
</script>
@endsection
