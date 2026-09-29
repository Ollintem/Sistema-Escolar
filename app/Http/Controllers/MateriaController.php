<?php

namespace App\Http\Controllers;

use App\Models\Materia; // <-- Usamos el modelo Materia
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::orderBy('id_materia', 'desc')->get();
        return view('materias.index', compact('materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|string|max:50|unique:subjects,clave',
            'nombre' => 'required|string|max:150',
        ]);

        Materia::create([
            'clave' => $request->clave,
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('materias.index')->with('success', 'Materia registrada correctamente.');
    }
}