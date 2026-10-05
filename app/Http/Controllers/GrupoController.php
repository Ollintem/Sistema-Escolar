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
            'id_grado'         => 'required|exists:grados,id_grado',
            'nombre'           => 'required|string',
            'turno'            => 'required|string',
            'id_ciclo'         => 'required|exists:ciclos_escolares,id_ciclo',
            'docente_id'       => 'nullable|exists:users,id',
            'materias'         => 'nullable|array',
            'docentes_materia' => 'nullable|array'
        ]);

        // 1. Buscamos el grado seleccionado para extraer su nombre
        $gradoModel = Grado::findOrFail($request->id_grado);

        // 2. Insertamos el nuevo grupo
        $grupo = Grupo::create([
            'id_grado'   => $request->id_grado,
            'grado'      => $gradoModel->nombre,
            'grupo'      => $request->nombre,
            'turno'      => $request->turno,
            'id_ciclo'   => $request->id_ciclo,
            'docente_id' => $request->docente_id,
        ]);

        // 3. Mapeamos cada materia seleccionada con su docente asignado
        if ($request->has('materias') && is_array($request->materias)) {
            $syncData = [];
            foreach ($request->materias as $materiaId) {
                $docenteMateria = $request->docentes_materia[$materiaId] ?? null;

                $syncData[$materiaId] = [
                    'docente_id' => $docenteMateria ?: null
                ];
            }

            $grupo->materias()->sync($syncData);
        }

        return redirect()->route('grupos.index')->with('success', 'Grupo creado y asignado correctamente.');
    }

    public function edit($id)
    {
        // Carga el grupo con las materias asignadas para prellenar el formulario en grupos/edit.blade.php
        $grupo = Grupo::with(['materias'])->findOrFail($id);

        $ciclos = CicloEscolar::where('estado', 'Activo')->get();
        $grados = Grado::orderBy('nombre', 'asc')->get();
        $docentes = User::role('Docente')->get();
        $materias = Materia::all();

        return view('grupos.edit', compact('grupo', 'ciclos', 'grados', 'docentes', 'materias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_grado'         => 'required|exists:grados,id_grado',
            'nombre'           => 'required|string',
            'turno'            => 'required|string',
            'id_ciclo'         => 'required|exists:ciclos_escolares,id_ciclo',
            'docente_id'       => 'nullable|exists:users,id',
            'materias'         => 'nullable|array',
            'docentes_materia' => 'nullable|array'
        ]);

        $grupo = Grupo::findOrFail($id);
        $gradoModel = Grado::findOrFail($request->id_grado);

        // 1. Actualizamos los datos generales del grupo
        $grupo->update([
            'id_grado'   => $request->id_grado,
            'grado'      => $gradoModel->nombre,
            'grupo'      => $request->nombre,
            'turno'      => $request->turno,
            'id_ciclo'   => $request->id_ciclo,
            'docente_id' => $request->docente_id,
        ]);

        // 2. Resincronizamos materias y sus docentes impartidores
        $syncData = [];
        if ($request->has('materias') && is_array($request->materias)) {
            foreach ($request->materias as $materiaId) {
                $docenteMateria = $request->docentes_materia[$materiaId] ?? null;

                $syncData[$materiaId] = [
                    'docente_id' => $docenteMateria ?: null
                ];
            }
        }

        // Si no se selecciona ninguna materia, sync($syncData) desvincula todas automáticamente
        $grupo->materias()->sync($syncData);

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);

        // Desvinculamos materias de la tabla pivote antes de eliminar el registro
        $grupo->materias()->detach();
        $grupo->delete();

        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado correctamente.');
    }
}