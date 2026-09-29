<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\CicloEscolar;
use App\Http\Requests\StoreAlumnoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumno::with(['grupo', 'ciclo']);

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', "%{$request->buscar}%")
                  ->orWhere('matricula', 'like', "%{$request->buscar}%");
        }

        $alumnos = $query->paginate(10);
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $ciclos = CicloEscolar::where('estado', 'Activo')->get();
        $grupos = Grupo::all();
        return view('alumnos.create', compact('ciclos', 'grupos'));
    }

    public function store(StoreAlumnoRequest $request)
    {
        $data = $request->validated();

        // Generación de Matrícula Automática
        $data['matricula'] = 'ALU-' . strtoupper(Str::random(6));

        // Subida de foto si aplica
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('alumnos_fotos', 'public');
            $data['foto'] = $path;
        }

        Alumno::create($data);

        return redirect()->route('alumnos.index')->with('success', 'Alumno inscrito correctamente.');
    }
}