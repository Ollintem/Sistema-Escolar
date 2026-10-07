<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CicloEscolarController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\CalificacionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpedienteController;
use Illuminate\Support\Facades\Storage;

// Redirección inicial
Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';
Auth::routes();

Route::middleware(['auth'])->group(function () {
    
    // Dashboard principal
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulo Alumnos
    Route::get('/alumnos', [AlumnoController::class, 'index'])->middleware('can:alumnos.mostrar')->name('alumnos.index');
    Route::get('/alumnos/create', [AlumnoController::class, 'create'])->middleware('can:alumnos.crear')->name('alumnos.create');
    Route::post('/alumnos', [AlumnoController::class, 'store'])->middleware('can:alumnos.crear')->name('alumnos.store');
    Route::get('/alumnos/{alumno}', [AlumnoController::class, 'show'])->middleware('can:alumnos.mostrar')->name('alumnos.show');
    Route::get('/alumnos/{alumno}/edit', [AlumnoController::class, 'edit'])->middleware('can:alumnos.editar')->name('alumnos.edit');

    // Rutas protegidas contra edición/eliminación de alumnos
    Route::middleware(['protect.admin'])->group(function () {
        Route::put('/alumnos/{alumno}', [AlumnoController::class, 'update'])->middleware('can:alumnos.editar')->name('alumnos.update');
        Route::delete('/alumnos/{alumno}', [AlumnoController::class, 'destroy'])->middleware('can:alumnos.eliminar')->name('alumnos.destroy');
    });

    // Módulo Ciclos Escolares
    Route::get('/ciclos', [CicloEscolarController::class, 'index'])->middleware('can:ciclos_escolares.mostrar')->name('ciclos.index');
    Route::post('/ciclos', [CicloEscolarController::class, 'store'])->middleware('can:ciclos_escolares.crear')->name('ciclos.store');
    Route::patch('/ciclos/{id}/toggle', [CicloEscolarController::class, 'toggleEstado'])->middleware('can:ciclos_escolares.editar')->name('ciclos.toggle');

    // Módulo Grupos
    Route::get('/grupos', [GrupoController::class, 'index'])->middleware('can:grupos.mostrar')->name('grupos.index');
    Route::post('/grupos', [GrupoController::class, 'store'])->middleware('can:grupos.crear')->name('grupos.store');
    Route::get('/grupos/{id}/edit', [GrupoController::class, 'edit'])->middleware('can:grupos.editar')->name('grupos.edit'); // <-- Nueva ruta para la vista edit.blade.php
    Route::put('/grupos/{id}', [GrupoController::class, 'update'])->middleware('can:grupos.editar')->name('grupos.update');
    Route::delete('/grupos/{id}', [GrupoController::class, 'destroy'])->middleware('can:grupos.eliminar')->name('grupos.destroy');

    // Módulo Materias
    Route::get('/materias', [MateriaController::class, 'index'])->middleware('can:materias.mostrar')->name('materias.index');
    Route::post('/materias', [MateriaController::class, 'store'])->middleware('can:materias.crear')->name('materias.store');

    // Reportes & Boletas
    Route::get('/boletas', function() {
        return view('boletas.index');
    })->middleware('can:boletas_reportes.mostrar')->name('boletas.index');

    // Módulo Personal & Ajustes del Sistema
    Route::prefix('personal')->group(function () {
        // Empleados
        Route::get('/empleados', [PersonalController::class, 'empleados'])->middleware('can:empleados.mostrar')->name('personal.empleados');
        Route::post('/empleados', [PersonalController::class, 'storeEmpleado'])->middleware('can:empleados.crear')->name('personal.empleados.store');
        Route::put('/empleados/{id}', [PersonalController::class, 'updateEmpleado'])->middleware('can:empleados.editar')->name('personal.empleados.update');
        Route::delete('/empleados/{id}', [PersonalController::class, 'destroyEmpleado'])->middleware('can:empleados.eliminar')->name('personal.empleados.destroy');

        // Roles & Permisos
        Route::get('/roles', [PersonalController::class, 'roles'])->middleware('can:roles_puestos.mostrar')->name('personal.roles');
        Route::post('/roles', [PersonalController::class, 'storeRole'])->middleware('can:roles_puestos.crear')->name('personal.roles.store');
        Route::get('/roles/{role}/permisos', [PersonalController::class, 'permisos'])->middleware('can:roles_puestos.gestionar')->name('personal.permisos');
        Route::put('/roles/{role}/permisos', [PersonalController::class, 'updatePermisos'])->middleware('can:roles_puestos.gestionar')->name('personal.permisos.update');

        // Creación rápida de Grados
        Route::post('/grados', [GrupoController::class, 'storeGrado'])->name('grados.store');

        // Módulo de Calificaciones
        Route::get('/calificaciones', [CalificacionController::class, 'index'])->name('calificaciones.index');
        Route::post('/calificaciones', [CalificacionController::class, 'store'])->name('calificaciones.store');

        // Módulo Expedientes y Alertas
        Route::get('/expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index');
        Route::get('/expedientes/{id}', [ExpedienteController::class, 'show'])->name('expedientes.show');
        Route::post('/expedientes/{id}/upload', [ExpedienteController::class, 'uploadDocument'])->name('expedientes.upload');
        Route::get('/expedientes/download/{idDocumento}', [ExpedienteController::class, 'downloadDocument'])->name('expedientes.download');
        Route::get('/expedientes/ver-archivo/{id}', function ($id) {
            $documento = \App\Models\StudentDocument::findOrFail($id);

            // Obtiene el valor intentando con los nombres de columna más comunes
            $path = $documento->archivo_path 
                ?? $documento->ruta_archivo 
                ?? $documento->path 
                ?? $documento->ruta 
                ?? $documento->file_path;

            // Si la columna es null o no existe en la BD
            if (!$path) {
                abort(404, 'La ruta del archivo está vacía en la base de datos.');
            }

            if (!Storage::disk('public')->exists($path)) {
                abort(404, 'El archivo no existe en el disco.');
            }

            return response()->file(storage_path('app/public/' . $path));
        })->name('expedientes.ver');
    });
    // Módulo de Asistencias
    Route::get('/asistencias', [\App\Http\Controllers\AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::post('/asistencias', [\App\Http\Controllers\AsistenciaController::class, 'store'])->name('asistencias.store');
});