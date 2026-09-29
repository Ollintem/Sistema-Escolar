<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::all();
        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        return view('docentes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:255',
            'apellido_p'   => 'required|string|max:255',
            'apellido_m'   => 'required|string|max:255',
            'correo'       => 'required|email|unique:docentes,correo',
            'telefono'     => 'required|string|max:20',
            'especialidad' => 'required|string|max:255',
        ]);

        Docente::create($validated);

        return redirect()->route('docentes.index')->with('success', 'Docente registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $docente = Docente::findOrFail($id);

        $validated = $request->validate([
            'nombre'       => 'required|string|max:255',
            'apellido_p'   => 'required|string|max:255',
            'apellido_m'   => 'required|string|max:255',
            'correo'       => 'required|email|unique:docentes,correo,' . $id . ',id_docente',
            'telefono'     => 'required|string|max:20',
            'especialidad' => 'required|string|max:255',
        ]);

        $docente->update($validated);

        return redirect()->route('docentes.index')->with('success', 'Docente actualizado correctamente.');
    }
    public function edit($id)
{
    $docente = Docente::findOrFail($id);
    return view('docentes.edit', compact('docente'));
}
}