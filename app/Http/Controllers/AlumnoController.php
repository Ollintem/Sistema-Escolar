<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlumnoRequest;
use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Muestra la lista de alumnos registrados.
     */
    public function index()
    {
        // Obtenemos los alumnos paginados de 10 en 10
        $alumnos = Alumno::orderBy('id_alumno', 'desc')->paginate(10);
        
        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Almacena un nuevo alumno en la base de datos tras validar con FormRequest.
     */
    public function store(StoreAlumnoRequest $request)
    {
        // Obtiene los datos ya validados por StoreAlumnoRequest
        Alumno::create($request->validated());

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno inscrito correctamente.');
    }

    /**
     * Muestra la información de un alumno específico.
     */
    public function show($id)
    {
        $alumno = Alumno::findOrFail($id);
        
        return view('alumnos.show', compact('alumno'));
    }
}