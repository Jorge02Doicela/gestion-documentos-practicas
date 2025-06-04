@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-white leading-tight">
        Dashboard
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto p-6 lg:p-8 text-white">
        <h1 class="text-3xl font-bold mb-4">Bienvenido, {{ Auth::user()->name }}</h1>

        <div class="bg-gray-800 rounded-lg shadow p-6 space-y-4">
            <p class="text-lg">Este es tu panel de control en el sistema <strong>Gestión de Documentos de Prácticas</strong>.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('documentos.index') }}"
                   class="bg-blue-600 hover:bg-blue-700 transition rounded-lg p-4 shadow text-center">
                    📁 Ver mis documentos
                </a>

                <a href="{{ route('documentos.create') }}"
                   class="bg-green-600 hover:bg-green-700 transition rounded-lg p-4 shadow text-center">
                    ⬆️ Subir nuevo documento
                </a>
            </div>
        </div>

        <div class="mt-6 text-sm text-gray-400">
            Último acceso: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
@endsection
