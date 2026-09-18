<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\CicloEscolar;
use App\Models\Docente;
use App\Models\Materia;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with(['ciclo', 'docenteTitular', 'materias'])->orderBy('id_grupo', 'desc')->get();
        $ciclos = CicloEscolar::where('estado', 'Activo')->get();
        $docentes = Docente::all();
        $materias = Materia::all();

        return view('grupos.index', compact('grupos', 'ciclos', 'docentes', 'materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'turno' => 'required|string|max:50',
            'id_ciclo' => 'required|exists:ciclos_escolares,id_ciclo',
            'id_docente' => 'nullable|exists:docentes,id_docente',
            'materias' => 'nullable|array',
        ]);

        $grupo = Grupo::create([
            'nombre' => $request->nombre,
            'turno' => $request->turno,
            'id_ciclo' => $request->id_ciclo,
            'id_docente' => $request->id_docente,
        ]);

        if ($request->has('materias')) {
            $grupo->materias()->sync($request->materias);
        }

        return redirect()->route('grupos.index')->with('success', 'Grupo registrado con éxito.');
    }
}