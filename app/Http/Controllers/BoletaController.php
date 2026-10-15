<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Calificacion;
use App\Models\Materia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BoletaController extends Controller
{
    public function index(Request $request)
    {
        $grupos = Grupo::all();
        $grupoId = $request->get('id_grupo');
        $alumnoId = $request->get('id_alumno');

        $alumnos = collect();
        $alumnoSeleccionado = null;
        $materias = collect();
        $calificaciones = collect();
        $promedioGeneral = 0;

        if ($grupoId) {
            $alumnos = Alumno::where('id_grupo', $grupoId)->orderBy('apellido_p')->get();
        }

        if ($alumnoId) {
            $alumnoSeleccionado = Alumno::with('grupo')->find($alumnoId);
            
            // Obtener materias del grupo
            if ($alumnoSeleccionado && $alumnoSeleccionado->grupo) {
                $materias = $alumnoSeleccionado->grupo->materias ?? collect();
            }

            if ($materias->isEmpty() && $grupoId) {
                $materias = Materia::whereIn('id_materia', function($query) use ($grupoId) {
                    $query->select('id_materia')
                          ->from('group_subject')
                          ->where('id_grupo', $grupoId);
                })->get();
            }

            // Cargar calificaciones indexadas por id_materia
            $calificaciones = Calificacion::where('id_alumno', $alumnoId)
                ->get()
                ->keyBy('id_materia');

            // Calcular promedio general usando 'promedio_final'
            $notasValidas = $calificaciones->pluck('promedio_final')->filter(function($val) {
                return !is_null($val);
            });

            if ($notasValidas->count() > 0) {
                $promedioGeneral = round($notasValidas->avg(), 1);
            }
        }

        return view('boletas.index', compact(
            'grupos',
            'grupoId',
            'alumnos',
            'alumnoId',
            'alumnoSeleccionado',
            'materias',
            'calificaciones',
            'promedioGeneral'
        ));
    }

    public function descargarPdf($alumnoId)
    {
        $alumno = Alumno::with('grupo')->findOrFail($alumnoId);
        
        $materias = $alumno->grupo->materias ?? collect();
        if ($materias->isEmpty()) {
            $materias = Materia::whereIn('id_materia', function($query) use ($alumno) {
                $query->select('id_materia')
                      ->from('group_subject')
                      ->where('id_grupo', $alumno->id_grupo);
            })->get();
        }

        $calificaciones = Calificacion::where('id_alumno', $alumnoId)
            ->get()
            ->keyBy('id_materia');

        $notasValidas = $calificaciones->pluck('promedio_final')->filter(function($val) {
            return !is_null($val);
        });

        $promedioGeneral = $notasValidas->count() > 0 ? round($notasValidas->avg(), 1) : 0;

        $pdf = Pdf::loadView('boletas.pdf', compact('alumno', 'materias', 'calificaciones', 'promedioGeneral'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->download('Boleta_' . $alumno->apellido_p . '_' . $alumno->nombre . '.pdf');
    }
}