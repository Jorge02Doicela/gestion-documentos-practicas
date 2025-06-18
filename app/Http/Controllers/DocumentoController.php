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
        ]);

        $path = $request->file('archivo')->store('documentos', 'public');

        Documento::create([
            'user_id' => Auth::id(),
            'nombre' => $request->nombre,
            'archivo' => $path,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento subido correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        if ($documento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para actualizar este documento.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Si se sube un nuevo archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior
            Storage::delete('public/documentos/' . $documento->archivo);

            // Guardar nuevo archivo
            $archivo = $request->file('archivo')->store('public/documentos');
            $documento->archivo = basename($archivo);
        }

        $documento->nombre = $request->nombre;
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
        Storage::delete('public/documentos/' . $documento->archivo);

        // Eliminar registro de la base de datos
        $documento->delete();

        return redirect()->route('documentos.index')
            ->with('success', 'Documento eliminado correctamente.');
    }
}
