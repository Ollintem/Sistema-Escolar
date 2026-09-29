<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\CicloEscolar;
use App\Models\Grado;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index(Request $request)
{
    $query = Alumno::with(['grupo.grado']);

    if ($request->filled('buscar')) {
        $buscar = $request->buscar;
        $query->where(function($q) use ($buscar) {
            $q->where('nombre', 'LIKE', "%{$buscar}%")
              ->orWhere('apellido_p', 'LIKE', "%{$buscar}%")
              ->orWhere('apellido_m', 'LIKE', "%{$buscar}%")
              ->orWhere('id_alumno', 'LIKE', "%{$buscar}%");
        });
    }

    $alumnos = $query->orderBy('id_alumno', 'desc')->paginate(10);

    return view('alumnos.index', compact('alumnos'));
}

    public function create()
    {
        $ciclos = CicloEscolar::where('estado', 'Activo')->get();
        $grados = Grado::all();
        
        // Carga los grupos existentes asegurando obtener su id_grupo correcto
        $grupos = Grupo::with(['grado', 'ciclo'])->get();

        return view('alumnos.create', compact('ciclos', 'grados', 'grupos'));
    }

    public function store(Request $request)
    {
        // Corregido: la tabla correcta en MySQL es 'ciclos_escolares' y 'groups'
        $request->validate([
            'nombre'                => 'required|string|max:100',
            'apellido_p'            => 'required|string|max:100',
            'apellido_m'            => 'nullable|string|max:100',
            'fecha_nacimiento'      => 'nullable|date',
            'curp'                  => 'nullable|string|max:18',
            'correo'                => 'nullable|email|max:150',
            'telefono'              => 'nullable|string|max:20',
            'tipo_sangre'           => 'nullable|string|max:10',
            'alergias'              => 'nullable|string|max:255',
            'observaciones_medicas' => 'nullable|string|max:500',
            'tutor_nombre'          => 'required|string|max:150',
            'tutor_parentesco'      => 'required|string|max:50',
            'tutor_telefono'        => 'required|string|max:20',
            'tutor_email'           => 'nullable|email|max:150',
            'id_grupo'              => 'required|exists:groups,id_grupo', // <-- Valida contra la tabla 'groups'
            'foto'                  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');

        // Manejo de la foto de perfil
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('alumnos', 'public');
        }

        Alumno::create($data);

        return redirect()->route('alumnos.index')->with('success', 'Alumno registrado correctamente.');
    }
}