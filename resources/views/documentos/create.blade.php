@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Subir nuevo documento</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 dark:text-gray-300">Nombre del documento:</label>
            <input type="text" name="nombre" id="nombre" class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600" required>
        </div>

        <div class="mb-4">
            <label for="archivo" class="block text-gray-700 dark:text-gray-300">Archivo (PDF, DOC, DOCX):</label>
            <input type="file" name="archivo" id="archivo" class="mt-1 block w-full text-white" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Subir Documento
        </button>
    </form>
</div>
@endsection
