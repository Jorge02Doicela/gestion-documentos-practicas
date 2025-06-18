{{-- resources/views/documentos/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8"> {{-- Added min-h-screen and a subtle background --}}
    <div class="max-w-4xl mx-auto px-4 space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex text-gray-700 dark:text-gray-300" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('documentos.index') }}" class="flex items-center text-sm font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Editar: {{ $documento->nombre }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6"> {{-- Rounded-xl and shadow-lg --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4"> {{-- Increased space-x --}}
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 bg-blue-50 dark:bg-blue-950 rounded-full flex items-center justify-center"> {{-- Larger, rounded icon background --}}
                            <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">Editar Documento</h2> {{-- Larger, bolder heading --}}
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Modifica la información y el archivo de tu documento</p> {{-- More descriptive text --}}
                    </div>
                </div>

                {{-- Estado actual --}}
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Estado actual:</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                        @if($documento->estado === 'pendiente') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                        @elseif($documento->estado === 'revisado_por_tutor') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @elseif($documento->estado === 'aprobado') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @endif">
                        {{ $documento->estado_formateado }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Mensajes de Error --}}
        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-800 dark:text-red-200 px-5 py-4 rounded-lg shadow-sm"> {{-- Slightly more padding --}}
                <div class="flex items-center mb-3"> {{-- Increased margin-bottom --}}
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold text-lg">Se encontraron errores:</span> {{-- Bolder, slightly larger text --}}
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Información del documento actual --}}
        <div class="bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-5 text-sm"> {{-- Rounded-xl and slightly more padding --}}
            <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-3 border-b border-gray-200 dark:border-gray-700 pb-2">Detalles del Documento</h3> {{-- Added border-bottom for subtle separation --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-3 gap-x-4"> {{-- More refined gap --}}
                <div>
                    <span class="text-gray-500 dark:text-gray-400 block">Creado:</span>
                    <span class="text-gray-900 dark:text-white font-medium">{{ $documento->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400 block">Última modificación:</span>
                    <span class="text-gray-900 dark:text-white font-medium">{{ $documento->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400 block">Tamaño:</span>
                    <span class="text-gray-900 dark:text-white font-medium">{{ $documento->tamaño_formateado }}</span>
                </div>
            </div>
        </div>

        {{-- Formulario --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700"> {{-- Rounded-xl and shadow-lg --}}
            <form action="{{ route('documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data" id="documento-form">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-7"> {{-- Increased space-y for more breathing room --}}
                    {{-- Información básica --}}
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-5">Información General</h3> {{-- Larger, bolder heading, more margin-bottom --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nombre del documento --}}
                            <div class="md:col-span-2">
                                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre del documento <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="nombre"
                                       name="nombre"
                                       value="{{ old('nombre', $documento->nombre) }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 dark:bg-gray-700 dark:text-white placeholder-gray-400 @error('nombre') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" {{-- Added placeholder color --}}
                                       placeholder="Ej: Tesis de Grado - Capítulo 1"
                                       required
                                       maxlength="255"> {{-- Added maxlength for consistency --}}
                                @error('nombre')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 char-counter">Máximo 255 caracteres</p> {{-- Added char-counter class for JS --}}
                            </div>

                            {{-- Descripción --}}
                            <div class="md:col-span-2">
                                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Descripción (opcional)
                                </label>
                                <textarea id="descripcion"
                                          name="descripcion"
                                          rows="4" {{-- Increased rows for better initial view --}}
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 dark:bg-gray-700 dark:text-white placeholder-gray-400 @error('descripcion') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                          placeholder="Describe brevemente el contenido del documento..."
                                          maxlength="1000">{{ old('descripcion', $documento->descripcion) }}</textarea> {{-- Added maxlength --}}
                                @error('descripcion')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 char-counter">Máximo 1000 caracteres</p> {{-- Added char-counter class for JS --}}
                            </div>
                        </div>
                    </div>

                    {{-- Estado y comentarios --}}
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-5">Estado y Comentarios</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Estado --}}
                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Estado del documento <span class="text-red-500">*</span>
                                </label>
                                <select id="estado"
                                        name="estado"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 dark:bg-gray-700 dark:text-white @error('estado') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                        required>
                                    <option value="pendiente" {{ old('estado', $documento->estado) == 'pendiente' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>
                                    <option value="revisado_por_tutor" {{ old('estado', $documento->estado) == 'revisado_por_tutor' ? 'selected' : '' }}>
                                        Revisado por Tutor
                                    </option>
                                    <option value="aprobado" {{ old('estado', $documento->estado) == 'aprobado' ? 'selected' : '' }}>
                                        Aprobado
                                    </option>
                                    <option value="rechazado" {{ old('estado', $documento->estado) == 'rechazado' ? 'selected' : '' }}>
                                        Rechazado
                                    </option>
                                </select>
                                @error('estado')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Comentarios --}}
                            <div>
                                <label for="comentarios" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Comentarios (opcional)
                                </label>
                                <textarea id="comentarios"
                                          name="comentarios"
                                          rows="4"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 dark:bg-gray-700 dark:text-white placeholder-gray-400 @error('comentarios') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                          placeholder="Añade comentarios sobre el documento..."
                                          maxlength="2000">{{ old('comentarios', $documento->comentarios) }}</textarea> {{-- Added maxlength --}}
                                @error('comentarios')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 char-counter">Máximo 2000 caracteres</p> {{-- Added char-counter class for JS --}}
                            </div>
                        </div>
                    </div>

                    {{-- Archivo --}}
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-5">Gestión de Archivo</h3> {{-- Changed heading --}}

                        {{-- Archivo actual --}}
                        @if($documento->archivo && $documento->archivoExiste())
                            <div class="mb-5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-inner"> {{-- shadow-inner for subtle effect --}}
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <span class="text-3xl">{{ $documento->getIconoArchivo() }}</span> {{-- Slightly larger icon --}}
                                        </div>
                                        <div>
                                            <p class="text-base font-medium text-gray-900 dark:text-white">{{ $documento->nombre_archivo }}</p> {{-- Slightly larger text --}}
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $documento->tamaño_formateado }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('documentos.download', $documento) }}"
                                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Subir nuevo archivo --}}
                        <div class="space-y-4">
                            <div>
                                <label for="archivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Reemplazar archivo (opcional)
                                </label>

                                {{-- Drag and Drop Area --}}
                                <div class="mt-1 flex justify-center px-6 pt-6 pb-7 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md transition-colors duration-200
                                            hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-950" {{-- Enhanced hover effect --}}
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
                                                       accept=".pdf,.doc,.docx">
                                            </label>
                                            <p class="pl-1">o arrastra y suelta</p>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, DOC, DOCX hasta 5MB
                                        </p>
                                    </div>
                                </div>

                                @error('archivo')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Preview del nuevo archivo seleccionado --}}
                            <div id="file-preview" class="hidden bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="h-9 w-9 text-blue-600" fill="currentColor" viewBox="0 0 20 20"> {{-- Larger icon --}}
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-base font-medium text-blue-900 dark:text-blue-100" id="file-name"></p> {{-- Slightly larger text --}}
                                            <p class="text-sm text-blue-700 dark:text-blue-300" id="file-size"></p>
                                        </div>
                                    </div>
                                    <button type="button"
                                            onclick="removeFile()"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-full p-1 transition-colors duration-200"> {{-- Added focus styles to remove button --}}
                                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"> {{-- Larger icon --}}
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-3 text-sm text-blue-700 dark:text-blue-300">
                                    ⚠️ Este archivo reemplazará el archivo actual cuando guardes los cambios.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Información adicional --}}
                    <div class="bg-amber-50 dark:bg-amber-900 border border-amber-200 dark:border-amber-700 rounded-lg p-4 shadow-sm"> {{-- Added subtle shadow --}}
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"> {{-- Slightly stronger amber color --}}
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-200">Información importante</h3> {{-- Bolder text --}}
                                <div class="mt-2 text-sm text-amber-700 dark:text-amber-300">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Si subes un nuevo archivo, reemplazará completamente el archivo actual.</li>
                                        <li>Los cambios de estado pueden afectar las notificaciones a otros usuarios.</li>
                                        <li>Solo puedes subir archivos en formato PDF, DOC o DOCX.</li>
                                        <li>El tamaño máximo del archivo es de 5MB.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="bg-gray-50 dark:bg-gray-900 px-6 py-5 flex justify-end space-x-4 rounded-b-xl border-t border-gray-200 dark:border-gray-700"> {{-- Increased padding, space-x, rounded-b-xl, and border-top --}}
                    <a href="{{ route('documentos.index') }}"
                       class="inline-flex items-center px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm"> {{-- Slightly larger padding and shadow --}}
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>

                    <button type="submit"
                            id="submit-btn"
                            class="inline-flex items-center px-5 py-2.5 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-60 disabled:cursor-not-allowed transition-colors duration-200 shadow-md"> {{-- Slightly larger padding, stronger shadow, adjusted disabled opacity --}}
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span id="submit-text">Actualizar Documento</span>
                    </button>
                </div>
            </form>
        </div>
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
    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
    }
    if (dropZone) {
        // Drag and drop event listeners are already on the element via ondrop, ondragover, ondragleave
    }
    document.getElementById('documento-form').addEventListener('submit', handleFormSubmit);

    // Funciones para drag and drop
    function dragOverHandler(ev) {
        ev.preventDefault();
        dropZone.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-950'); // Match new hover class
    }

    function dragLeaveHandler(ev) {
        ev.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-950'); // Match new hover class
    }

    function dropHandler(ev) {
        ev.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-950'); // Match new hover class

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
            const errors = validateFile(file); // Use the new validateFile function

            if (errors.length > 0) {
                alert(errors.join('\n')); // Show all errors
                fileInput.value = ''; // Clear the input
                filePreview.classList.add('hidden');
                dropZone.classList.remove('hidden');
                return;
            }

            // Mostrar preview
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            filePreview.classList.remove('hidden');
            dropZone.classList.add('hidden');
        } else {
            // If file input is cleared (e.g., manually removing a selected file)
            removeFile();
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
    function handleFormSubmit(event) {
        // Deshabilitar botón de envío para evitar doble envío
        submitBtn.disabled = true;
        submitText.textContent = 'Actualizando...';

        // Agregar spinner al botón
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Actualizando...
        `;

        // The form will submit normally after this
        return true;
    }

    // Validación en tiempo real del formulario
    document.addEventListener('DOMContentLoaded', function() {
        const nombreInput = document.getElementById('nombre');
        const descripcionTextarea = document.getElementById('descripcion');
        const comentariosTextarea = document.getElementById('comentarios');

        // Helper function for character counting and validation
        function setupCharCounter(inputElement, maxLength) {
            if (!inputElement) return;

            // Find or create the character counter paragraph specific to this input
            let counter = inputElement.nextElementSibling; // Check next sibling for the char counter
            while (counter && !counter.classList.contains('char-counter')) {
                counter = counter.nextElementSibling;
            }

            if (!counter) {
                counter = document.createElement('p');
                counter.className = 'char-counter mt-1 text-xs text-gray-500 dark:text-gray-400'; // Made text smaller for char counter
                inputElement.parentNode.insertBefore(counter, inputElement.nextSibling); // Insert after input
            }

            const updateCounter = () => {
                const currentLength = inputElement.value.length;
                const remainingChars = maxLength - currentLength;

                counter.textContent = `${remainingChars} caracteres restantes`;

                if (remainingChars < 0) {
                    counter.classList.remove('text-gray-500', 'dark:text-gray-400');
                    counter.classList.add('text-red-600', 'dark:text-red-400', 'font-semibold'); // Added font-semibold
                    inputElement.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                } else {
                    counter.classList.remove('text-red-600', 'dark:text-red-400', 'font-semibold');
                    counter.classList.add('text-gray-500', 'dark:text-gray-400');
                    inputElement.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                }
            };

            inputElement.addEventListener('input', updateCounter);
            // Initial call to set the correct counter text and style on load
            updateCounter();
        }

        setupCharCounter(nombreInput, 255);
        setupCharCounter(descripcionTextarea, 1000);
        setupCharCounter(comentariosTextarea, 2000);
    });

    // Confirmación antes de salir si hay cambios sin guardar
    let formChanged = false;
    const form = document.getElementById('documento-form');
    const formInputs = form.querySelectorAll('input, textarea, select');

    formInputs.forEach(input => {
        input.addEventListener('change', () => {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
            return 'Tienes cambios sin guardar. ¿Estás seguro de que quieres salir?';
        }
    });

    // Resetear flag cuando se envía el formulario
    form.addEventListener('submit', () => {
        formChanged = false;
    });

    // Función para validar archivos de manera más robusta (moved here for clarity)
    function validateFile(file) {
        const errors = [];

        // Validar tipo de archivo
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        const allowedExtensions = ['pdf', 'doc', 'docx']; // Explicitly check extensions too

        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
            errors.push('Tipo de archivo no permitido. Solo se permiten archivos PDF, DOC y DOCX.');
        }

        // Validar tamaño (5MB)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            errors.push(`El archivo es demasiado grande. Tamaño actual: ${formatFileSize(file.size)}. El tamaño máximo permitido es 5MB.`);
        }
        return errors;
    }

    // Initial check for file input if there's an old file error or already selected
    document.addEventListener('DOMContentLoaded', () => {
        if (fileInput && fileInput.files.length > 0) {
            handleFileSelect();
        }
    });
</script>
@endsection
