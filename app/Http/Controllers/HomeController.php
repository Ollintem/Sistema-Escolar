<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\CicloEscolar;
use App\Models\Grupo;
use App\Models\Docente;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Conteos principales para las tarjetas
        $totalAlumnos = Alumno::count();
        $totalGrupos = Grupo::count();
        $cicloActivo = CicloEscolar::where('estado', 'Activo')->latest('id_ciclo')->first();
        $totalDocentes = Docente::count();

        // Obtener los últimos grupos registrados para la vista rápida
        $ultimosGrupos = Grupo::with(['ciclo', 'docenteTitular'])
            ->orderBy('id_grupo', 'desc')
            ->take(5)
            ->get();

        return view('home', compact(
            'totalAlumnos',
            'totalGrupos',
            'cicloActivo',
            'totalDocentes',
            'ultimosGrupos'
        ));
    }
}