<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProfileController;

// Ruta pública de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Ruta protegida del dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas para usuarios autenticados
Route::middleware(['auth'])->group(function () {

    // Rutas RESTful para documentos (index, create, store, show, edit, update, destroy)
    Route::resource('documentos', DocumentoController::class);

    // Ruta de descarga usando model binding - cambiado {id} por {documento}
    Route::get('/documentos/{documento}/descargar', [DocumentoController::class, 'download'])->name('documentos.download');

    // Rutas para edición y gestión del perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación generadas por Breeze, Jetstream, etc.
require __DIR__ . '/auth.php';
