{{-- resources/views/documentos/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4 bg-white dark:bg-gray-800 rounded shadow">
    <h2 class="text-2xl mb-4 text-gray-800 dark:text-gray-200">Mis Documentos</h2>

    @if(session('success'))
        <div class="mb-4 p-2 bg-green-500 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('documentos.create') }}" class="inline-block mb-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        Subir nuevo documento
    </a>

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

                    <td class="p-2">
                        @switch($doc->estado)
                            @case('pendiente')
                                <span class="text-yellow-600 font-semibold">Pendiente</span>
                                @break
                            @case('revisado_por_tutor')
                                <span class="text-blue-600 font-semibold">Revisado por Tutor</span>
                                @break
                            @case('aprobado')
                                <span class="text-green-600 font-semibold">Aprobado</span>
                                @break
                            @case('rechazado')
                                <span class="text-red-600 font-semibold">Rechazado</span>
                                @break
                            @default
                                <span>{{ ucfirst(str_replace('_', ' ', $doc->estado)) }}</span>
                        @endswitch
                    </td>

                    <td class="p-2">{{ $doc->created_at->format('d/m/Y') }}</td>

                    <td class="p-2 flex gap-2 items-center">
                        <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank" class="text-blue-500 underline">
                            Ver
                        </a>

                        <a href="{{ route('documentos.edit', $doc->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                            Editar
                        </a>

                        <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este documento?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                Eliminar
                            </button>
                        </form>
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
