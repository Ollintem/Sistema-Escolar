<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Alumno;
use App\Models\Calificacion;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function index(Request $request)
    {
        $grupos = Grupo::with(['grado', 'materias'])->get();
        $grupoSeleccionado = null;
        $materiaSeleccionada = null;
        $alumnos = collect();
        $calificaciones = collect();

        if ($request->filled('id_grupo') && $request->filled('id_materia')) {
            $grupoSeleccionado = Grupo::with(['grado', 'materias'])->find($request->id_grupo);
        
            // Búsqueda directa sin la columna 'id' inexistente
            $materiaSeleccionada = Materia::find($request->id_materia);

            if ($grupoSeleccionado && $materiaSeleccionada) {
                $alumnos = Alumno::where('id_grupo', $request->id_grupo)
                    ->orderBy('apellido_p')
                    ->get();

                $calificaciones = Calificacion::where('id_grupo', $request->id_grupo)
                    ->where('id_materia', $request->id_materia)
                    ->get()
                    ->keyBy('id_alumno');
            }
        }

        return view('calificaciones.index', compact(
            'grupos',
            'grupoSeleccionado',
            'materiaSeleccionada',
            'alumnos',
            'calificaciones'
        ));
    }

    public function store(Request $request)
    {
        // Validación estricta para notas entre 0.0 y 10.0
        $request->validate([
            'id_grupo' => 'required|exists:groups,id_grupo',
            'id_materia' => 'required',
            'calificaciones' => 'required|array',
            'calificaciones.*.parcial_1' => 'nullable|numeric|min:0|max:10',
            'calificaciones.*.parcial_2' => 'nullable|numeric|min:0|max:10',
            'calificaciones.*.parcial_3' => 'nullable|numeric|min:0|max:10',
        ]);

        foreach ($request->calificaciones as $alumnoId => $notas) {
            $p1 = isset($notas['parcial_1']) && $notas['parcial_1'] !== '' ? (float)$notas['parcial_1'] : null;
            $p2 = isset($notas['parcial_2']) && $notas['parcial_2'] !== '' ? (float)$notas['parcial_2'] : null;
            $p3 = isset($notas['parcial_3']) && $notas['parcial_3'] !== '' ? (float)$notas['parcial_3'] : null;

            // Cálculo dinámico de promedio final
            $sum = 0;
            $count = 0;
            if ($p1 !== null) { $sum += $p1; $count++; }
            if ($p2 !== null) { $sum += $p2; $count++; }
            if ($p3 !== null) { $sum += $p3; $count++; }

            $promedio = $count > 0 ? round($sum / $count, 2) : null;

            Calificacion::updateOrCreate(
                [
                    'id_alumno'  => $alumnoId,
                    'id_materia' => $request->id_materia,
                    'id_grupo'   => $request->id_grupo,
                ],
                [
                    'parcial_1'      => $p1,
                    'parcial_2'      => $p2,
                    'parcial_3'      => $p3,
                    'promedio_final' => $promedio,
                    'observaciones'  => $notas['observaciones'] ?? null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Calificaciones registradas y promedios calculados exitosamente.');
    }
}