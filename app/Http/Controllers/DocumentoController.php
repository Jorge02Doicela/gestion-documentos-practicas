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
    $documentos = Documento::where('user_id', auth()->id())->latest()->get();

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
