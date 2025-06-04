@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4 bg-white dark:bg-gray-800 rounded shadow">
    <h2 class="text-2xl mb-4 text-gray-800 dark:text-gray-200">Mis Documentos</h2>

    @if(session('success'))
        <div class="mb-4 p-2 bg-green-500 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('documentos.create') }}" class="inline-block mb-4 bg-blue-600 text-white px-4 py-2 rounded">Subir nuevo documento</a>

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-200 dark:bg-gray-700 text-left">
                <th class="p-2">Nombre</th>
                <th class="p-2">Estado</th>
                <th class="p-2">Fecha</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentos as $doc)
            <tr class="border-b dark:border-gray-600">
                <td class="p-2">{{ $doc->nombre }}</td>
                <td class="p-2">{{ ucfirst($doc->estado) }}</td>
                <td class="p-2">{{ $doc->created_at->format('d/m/Y') }}</td>
                <td class="p-2">
                    <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank" class="text-blue-500 underline">Ver</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">No hay documentos aún.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
