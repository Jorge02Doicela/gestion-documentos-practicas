<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentos = Documento::where('user_id', Auth::id())->latest()->get();

        return view('documentos.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('documentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'nombre.required' => 'El nombre del documento es obligatorio.',
            'nombre.max' => 'El nombre del documento no puede tener más de 255 caracteres.',
            'archivo.required' => 'Debes seleccionar un archivo.',
            'archivo.file' => 'El archivo seleccionado no es válido.',
            'archivo.mimes' => 'El archivo debe ser de tipo: PDF, DOC o DOCX.',
            'archivo.max' => 'El archivo no puede ser mayor a 2MB.',
        ]);

        $path = $request->file('archivo')->store('documentos', 'public');

        Documento::create([
            'user_id' => Auth::id(),
            'nombre' => $request->nombre,
            'archivo' => $path,
            'estado' => 'pendiente', // Siempre crear como pendiente
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento subido correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $documento = Documento::findOrFail($id);

        // Verificar que el documento pertenece al usuario autenticado
        if ($documento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este documento.');
        }

        return view('documentos.show', compact('documento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documento $documento)
    {
        if ($documento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar este documento.');
        }

        return view('documentos.edit', compact('documento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Documento $documento)
    {
        // Verificar que el documento pertenece al usuario autenticado
        if ($documento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para actualizar este documento.');
        }

        // Validar datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'estado' => 'required|in:pendiente,revisado_por_tutor,aprobado,rechazado',
            'comentarios' => 'nullable|string',
        ]);

        // Asignar nuevos valores al modelo
        $documento->nombre = $request->nombre;
        $documento->estado = $request->estado;
        $documento->comentarios = $request->comentarios;

        // Si suben un nuevo archivo, actualizarlo
        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if ($documento->archivo && Storage::disk('public')->exists($documento->archivo)) {
                Storage::disk('public')->delete($documento->archivo);
            }

            // Guardar el nuevo archivo
            $path = $request->file('archivo')->store('documentos', 'public');
            $documento->archivo = $path;
        }

        // Guardar cambios en la base de datos
        $documento->save();

        return redirect()->route('documentos.index')
            ->with('success', 'Documento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documento $documento)
    {
        // Verificar que el documento pertenece al usuario autenticado
        if ($documento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este documento.');
        }

        // Eliminar archivo físico del almacenamiento
        if ($documento->archivo && Storage::disk('public')->exists($documento->archivo)) {
            Storage::disk('public')->delete($documento->archivo);
        }

        // Eliminar registro de la base de datos
        $documento->delete();

        return redirect()->route('documentos.index')
            ->with('success', 'Documento eliminado correctamente.');
    }
}
