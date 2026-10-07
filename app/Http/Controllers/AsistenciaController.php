<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Obtener grupos y materias
        $grupos = Grupo::all();
        $materias = Materia::all();

        // 2. Parámetros del request
        $grupoId = $request->get('id_grupo');
        $materiaId = $request->get('id_materia');
        $fecha = $request->get('fecha', Carbon::today()->format('Y-m-d'));

        $alumnos = collect();
        $asistenciasExistentes = collect();

        // 3. Si hay grupo seleccionado, cargar alumnos y sus asistencias
        if ($grupoId) {
            $alumnos = Alumno::where('id_grupo', $grupoId)
                ->orderBy('apellido_p')
                ->get();

            // Cargar asistencias previas
            $queryAsistencias = Asistencia::where('id_grupo', $grupoId)
                ->where('fecha', $fecha);

            if ($materiaId) {
                $queryAsistencias->where('id_materia', $materiaId);
            }

            $asistenciasExistentes = $queryAsistencias->get()->keyBy('id_alumno');
        }

        // 4. Enviar variables con nombres exactos en español a compact()
        return view('asistencias.index', compact(
            'grupos',
            'materias',
            'alumnos',
            'grupoId',
            'materiaId',
            'fecha',
            'asistenciasExistentes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_grupo' => 'required',
            'fecha' => 'required|date',
            'asistencias' => 'required|array',
        ]);

        $grupoId = $request->id_grupo;
        $materiaId = $request->id_materia ?: null;
        $fecha = $request->fecha;

        foreach ($request->asistencias as $alumnoId => $estatus) {
            Asistencia::updateOrCreate(
                [
                    'id_alumno' => $alumnoId,
                    'id_materia' => $materiaId,
                    'fecha' => $fecha,
                ],
                [
                    'id_grupo' => $grupoId,
                    'estatus' => $estatus,
                ]
            );
        }

        return redirect()->back()->with('success', 'Asistencias guardadas correctamente.');
    }
}