<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\CicloEscolar;
use App\Models\Grupo;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 1. Conteos principales
        $totalAlumnos = Alumno::count();
        $totalGrupos = Grupo::count();
        $totalDocentes = User::role('Docente')->count(); // Conteo vía roles Spatie
        $cicloActivo = CicloEscolar::where('estado', 'Activo')->latest('id_ciclo')->first();

        // 2. Últimos grupos registrados
        $ultimosGrupos = Grupo::with(['grado', 'ciclo', 'docenteTitular'])
            ->orderBy('id_grupo', 'desc')
            ->take(5)
            ->get();

        // 3. Control de Alertas: Expedientes Incompletos (Alumnos con menos de 4 documentos)
        $expedientesIncompletos = Alumno::with(['grupo.grado'])
            ->withCount('documentos')
            ->having('documentos_count', '<', 4)
            ->take(5)
            ->get();

        $expedientesIncompletosCount = Alumno::withCount('documentos')
            ->having('documentos_count', '<', 4)
            ->count();

        return view('home', compact(
            'totalAlumnos',
            'totalGrupos',
            'totalDocentes',
            'cicloActivo',
            'ultimosGrupos',
            'expedientesIncompletos',
            'expedientesIncompletosCount'
        ));
    }
}