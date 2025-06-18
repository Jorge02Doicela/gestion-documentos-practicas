{{-- resources/views/documentos/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 space-y-6">
    {{-- Breadcrumb --}}
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-1 md:space-x-3">
            <li class="flex items-center">
                <a href="{{ route('documentos.index') }}" class="text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Mis Documentos
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-500 dark:text-gray-400">Subir Documento</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Subir Nuevo Documento</h2>
                <p class="text-gray-600 dark:text-gray-400">Completa la información y selecciona el archivo que deseas subir</p>
            </div>
        </div>
    </div>

    {{-- Mensajes de Error --}}
    @if ($errors->any())
        <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">Se encontraron errores:</span>
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
        <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data" id="documento-form">
            @csrf

            <div class="p-6 space-y-6">
                {{-- Información básica --}}
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Información del Documento</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nombre del documento --}}
                        <div class="md:col-span-2">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre del documento
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('nombre') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Ej: Tesis de Grado - Capítulo 1"
                                   required>
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Máximo 255 caracteres</p>
                        </div>

                        {{-- Descripción --}}
                        <div class="md:col-span-2">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Descripción (opcional)
                            </label>
                            <textarea id="descripcion"
                                      name="descripcion"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('descripcion') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                      placeholder="Describe brevemente el contenido del documento...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Máximo 1000 caracteres</p>
                        </div>
                    </div>
                </div>

                {{-- Archivo --}}
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Archivo</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="archivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Seleccionar archivo
                                <span class="text-red-500">*</span>
                            </label>

                            {{-- Drag and Drop Area --}}
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-gray-400 dark:hover:border-gray-500 transition-colors duration-200"
                                 id="drop-zone"
                                 ondrop="dropHandler(event);"
                                 ondragover="dragOverHandler(event);"
                                 ondragleave="dragLeaveHandler(event);">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="archivo" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Subir un archivo</span>
                                            <input id="archivo"
                                                   name="archivo"
                                                   type="file"
                                                   class="sr-only"
                                                   accept=".pdf,.doc,.docx"
                                                   required>
                                        </label>
                                        <p class="pl-1">o arrastra y suelta</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PDF, DOC, DOCX hasta 5MB
                                    </p>
                                </div>
                            </div>

                            @error('archivo')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Preview del archivo seleccionado --}}
                        <div id="file-preview" class="hidden bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white" id="file-name"></p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400" id="file-size"></p>
                                    </div>
                                </div>
                                <button type="button"
                                        onclick="removeFile()"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información adicional --}}
                <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Información importante</h3>
                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>El documento se creará con estado "Pendiente" por defecto</li>
                                    <li>Solo puedes subir archivos en formato PDF, DOC o DOCX</li>
                                    <li>El tamaño máximo del archivo es de 5MB</li>
                                    <li>El nombre del documento debe ser único</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 flex justify-end space-x-3 rounded-b-lg">
                <a href="{{ route('documentos.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>

                <button type="submit"
                        id="submit-btn"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <span id="submit-text">Subir Documento</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Variables globales
let dropZone = document.getElementById('drop-zone');
let fileInput = document.getElementById('archivo');
let filePreview = document.getElementById('file-preview');
let fileName = document.getElementById('file-name');
let fileSize = document.getElementById('file-size');
let submitBtn = document.getElementById('submit-btn');
let submitText = document.getElementById('submit-text');

// Event listeners
fileInput.addEventListener('change', handleFileSelect);
document.getElementById('documento-form').addEventListener('submit', handleFormSubmit);

// Funciones para drag and drop
function dragOverHandler(ev) {
    ev.preventDefault();
    dropZone.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
}

function dragLeaveHandler(ev) {
    ev.preventDefault();
    dropZone.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');
}

function dropHandler(ev) {
    ev.preventDefault();
    dropZone.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900');

    let files = ev.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        handleFileSelect();
    }
}

// Manejar selección de archivo
function handleFileSelect() {
    let file = fileInput.files[0];
    if (file) {
        // Validar tipo de archivo
        let allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!allowedTypes.includes(file.type)) {
            alert('Tipo de archivo no permitido. Solo se permiten archivos PDF, DOC y DOCX.');
            fileInput.value = '';
            return;
        }

        // Validar tamaño (5MB = 5 * 1024 * 1024 bytes)
        if (file.size > 5 * 1024 * 1024) {
            alert('El archivo es demasiado grande. El tamaño máximo permitido es 5MB.');
            fileInput.value = '';
            return;
        }

        // Mostrar preview
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        filePreview.classList.remove('hidden');
        dropZone.classList.add('hidden');
    }
}

// Remover archivo seleccionado
function removeFile() {
    fileInput.value = '';
    filePreview.classList.add('hidden');
    dropZone.classList.remove('hidden');
}

// Formatear tamaño de archivo
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Manejar envío del formulario
function handleFormSubmit(e) {
    submitBtn.disabled = true;
    submitText.textContent = 'Subiendo...';

    // Agregar spinner
    submitBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Subiendo...
    `;
}

// Contador de caracteres para descripción
document.getElementById('descripcion').addEventListener('input', function() {
    let maxLength = 1000;
    let currentLength = this.value.length;
    let remaining = maxLength - currentLength;

    // Crear o actualizar contador si no existe
    let counter = document.getElementById('descripcion-counter');
    if (!counter) {
        counter = document.createElement('p');
        counter.id = 'descripcion-counter';
        counter.className = 'mt-1 text-sm text-gray-500 dark:text-gray-400';
        this.parentNode.appendChild(counter);
    }

    counter.textContent = `${currentLength}/${maxLength} caracteres`;

    if (remaining < 0) {
        counter.className = 'mt-1 text-sm text-red-600 dark:text-red-400';
    } else if (remaining < 100) {
        counter.className = 'mt-1 text-sm text-yellow-600 dark:text-yellow-400';
    } else {
        counter.className = 'mt-1 text-sm text-gray-500 dark:text-gray-400';
    }
});
</script>
@endsection
