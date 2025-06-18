<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Documento::where('user_id', Auth::id());

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Búsqueda por nombre
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        // Ordenamiento
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $allowedSortFields = ['nombre', 'estado', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->latest();
        }

        $documentos = $query->paginate(10)->appends($request->query());

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
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:documentos,nombre,NULL,id,user_id,' . Auth::id(),
            'archivo' => 'required|file|mimes:pdf,doc,docx|max:5120', // Aumentado a 5MB
            'descripcion' => 'nullable|string|max:1000',
        ], [
            'nombre.required' => 'El nombre del documento es obligatorio.',
            'nombre.max' => 'El nombre del documento no puede tener más de 255 caracteres.',
            'nombre.unique' => 'Ya tienes un documento con este nombre.',
            'archivo.required' => 'Debes seleccionar un archivo.',
            'archivo.file' => 'El archivo seleccionado no es válido.',
            'archivo.mimes' => 'El archivo debe ser de tipo: PDF, DOC o DOCX.',
            'archivo.max' => 'El archivo no puede ser mayor a 5MB.',
            'descripcion.max' => 'La descripción no puede tener más de 1000 caracteres.',
        ]);

        try {
            // Generar nombre único para el archivo
            $originalName = $request->file('archivo')->getClientOriginalName();
            $extension = $request->file('archivo')->getClientOriginalExtension();
            $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;

            $path = $request->file('archivo')->storeAs('documentos', $fileName, 'public');

            Documento::create([
                'user_id' => Auth::id(),
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'] ?? null,
                'archivo' => $path,
                'nombre_archivo' => $originalName,
                'tamaño_archivo' => $request->file('archivo')->getSize(),
                'estado' => 'pendiente',
            ]);

            return redirect()->route('documentos.index')
                ->with('success', 'Documento subido correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al subir documento: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al subir el documento. Inténtalo de nuevo.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Documento $documento)
    {
        // Verificación manual de autorización
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
        // Verificación manual de autorización
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
        // Verificación manual de autorización
        if ($documento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para actualizar este documento.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:documentos,nombre,' . $documento->id . ',id,user_id,' . Auth::id(),
            'archivo' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'estado' => 'required|in:pendiente,revisado_por_tutor,aprobado,rechazado',
            'comentarios' => 'nullable|string|max:2000',
            'descripcion' => 'nullable|string|max:1000',
        ], [
            'nombre.required' => 'El nombre del documento es obligatorio.',
            'nombre.unique' => 'Ya tienes un documento con este nombre.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
            'comentarios.max' => 'Los comentarios no pueden tener más de 2000 caracteres.',
            'descripcion.max' => 'La descripción no puede tener más de 1000 caracteres.',
        ]);

        try {
            // Actualizar campos básicos
            $documento->fill($validated);

            // Manejar nuevo archivo si se subió
            if ($request->hasFile('archivo')) {
                // Eliminar archivo anterior
                if ($documento->archivo && Storage::disk('public')->exists($documento->archivo)) {
                    Storage::disk('public')->delete($documento->archivo);
                }

                // Subir nuevo archivo
                $originalName = $request->file('archivo')->getClientOriginalName();
                $extension = $request->file('archivo')->getClientOriginalExtension();
                $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;

                $path = $request->file('archivo')->storeAs('documentos', $fileName, 'public');
                $documento->archivo = $path;
                $documento->nombre_archivo = $originalName;
                $documento->tamaño_archivo = $request->file('archivo')->getSize();
            }

            $documento->save();

            return redirect()->route('documentos.index')
                ->with('success', 'Documento actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar documento: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al actualizar el documento. Inténtalo de nuevo.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documento $documento)
    {
        // Verificación manual de autorización
        if ($documento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este documento.');
        }

        try {
            // Eliminar archivo físico
            if ($documento->archivo && Storage::disk('public')->exists($documento->archivo)) {
                Storage::disk('public')->delete($documento->archivo);
            }

            $documento->delete();

            return redirect()->route('documentos.index')
                ->with('success', 'Documento eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar documento: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al eliminar el documento. Inténtalo de nuevo.']);
        }
    }

    /**
     * Download the document file.
     */
    public function download(Documento $documento)
    {
        // Verificación manual de autorización
        if ($documento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para descargar este documento.');
        }

        if (!$documento->archivo || !Storage::disk('public')->exists($documento->archivo)) {
            return back()->withErrors(['error' => 'El archivo no existe o ha sido eliminado.']);
        }

        return Storage::disk('public')->download($documento->archivo, $documento->nombre_archivo);
    }

    /**
     * Get documents statistics for the authenticated user.
     */
    public function estadisticas()
    {
        $userId = Auth::id();

        $stats = [
            'total' => Documento::where('user_id', $userId)->count(),
            'pendientes' => Documento::where('user_id', $userId)->where('estado', 'pendiente')->count(),
            'revisados' => Documento::where('user_id', $userId)->where('estado', 'revisado_por_tutor')->count(),
            'aprobados' => Documento::where('user_id', $userId)->where('estado', 'aprobado')->count(),
            'rechazados' => Documento::where('user_id', $userId)->where('estado', 'rechazado')->count(),
        ];

        return response()->json($stats);
    }
}
