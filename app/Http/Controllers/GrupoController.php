<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Grado;
use App\Models\CicloEscolar;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with(['docenteTitular', 'materias', 'ciclo', 'grado'])
            ->orderBy('id_grupo', 'desc')
            ->get();

        $ciclos = CicloEscolar::where('estado', 'Activo')->get();
        $grados = Grado::orderBy('nombre', 'asc')->get();
        $docentes = User::role('Docente')->get();
        $materias = Materia::all();

        return view('grupos.index', compact('grupos', 'ciclos', 'grados', 'docentes', 'materias'));
    }

    public function storeGrado(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
        ]);

        Grado::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('grupos.index')->with('success', 'Grado creado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_grado' => 'required|exists:grados,id_grado',
            'nombre' => 'required|string', // Viene del input del modal
            'turno' => 'required|string',
            'id_ciclo' => 'required|exists:ciclos_escolares,id_ciclo',
            'docente_id' => 'nullable|exists:users,id',
            'materias' => 'nullable|array'
        ]);

        // 1. Buscamos el grado seleccionado para extraer su nombre
        $gradoModel = Grado::findOrFail($request->id_grado);

        // 2. Insertamos guardando tanto 'id_grado' como 'grado' para satisfacer la restricción NOT NULL
        $grupo = Grupo::create([
            'id_grado' => $request->id_grado,
            'grado'    => $gradoModel->nombre, // <-- Satisface la columna 'grado' NOT NULL
            'grupo'    => $request->nombre,     // <-- Columna 'grupo'
            'turno'    => $request->turno,
            'id_ciclo' => $request->id_ciclo,
            'docente_id' => $request->docente_id,
        ]);

        if ($request->has('materias')) {
            $grupo->materias()->sync($request->materias);
        }

        return redirect()->route('grupos.index')->with('success', 'Grupo creado y asignado correctamente.');
    }
}