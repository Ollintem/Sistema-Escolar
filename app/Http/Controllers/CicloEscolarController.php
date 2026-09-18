<?php

namespace App\Http\Controllers;

use App\Models\CicloEscolar;
use Illuminate\Http\Request;

class CicloEscolarController extends Controller
{
    public function index()
    {
        $ciclos = CicloEscolar::orderBy('id_ciclo', 'desc')->get();
        return view('ciclos.index', compact('ciclos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        CicloEscolar::create([
            'nombre' => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'Activo',
        ]);

        return redirect()->route('ciclos.index')->with('success', 'Ciclo escolar aperturado correctamente.');
    }

    public function toggleEstado($id)
    {
        $ciclo = CicloEscolar::findOrFail($id);
        $ciclo->estado = ($ciclo->estado === 'Activo') ? 'Cerrado' : 'Activo';
        $ciclo->save();

        return redirect()->route('ciclos.index')->with('success', 'Estado del ciclo escolar actualizado.');
    }
}