<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CicloEscolarController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\MateriaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';
Auth::routes();

Route::middleware(['auth'])->group(function () {
    
    // Dashboard (Libre de restricciones para todo usuario autenticado)
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

    // Rutas protegidas contra edición/eliminación
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

    // Módulo Materias
    Route::get('/materias', [MateriaController::class, 'index'])->middleware('can:materias.mostrar')->name('materias.index');
    Route::post('/materias', [MateriaController::class, 'store'])->middleware('can:materias.crear')->name('materias.store');

    // Módulos de vistas directas
    Route::get('/boletas', function() {
        return view('boletas.index');
    })->middleware('can:boletas_reportes.mostrar')->name('boletas.index');

    // Módulo Personal (Empleados / Roles / Permisos)
    Route::prefix('personal')->group(function () {
        // Empleados
        Route::get('/empleados', [PersonalController::class, 'empleados'])->middleware('can:empleados.mostrar')->name('personal.empleados');
        Route::post('/empleados', [PersonalController::class, 'storeEmpleado'])->middleware('can:empleados.crear')->name('personal.empleados.store');
        Route::put('/empleados/{id}', [PersonalController::class, 'updateEmpleado'])->middleware('can:empleados.editar')->name('personal.empleados.update');
        Route::delete('/empleados/{id}', [PersonalController::class, 'destroyEmpleado'])->middleware('can:empleados.eliminar')->name('personal.empleados.destroy');

        // Roles / Puestos
        Route::get('/roles', [PersonalController::class, 'roles'])->middleware('can:roles_puestos.mostrar')->name('personal.roles');
        Route::post('/roles', [PersonalController::class, 'storeRole'])->middleware('can:roles_puestos.crear')->name('personal.roles.store');

        // Matriz de Permisos por Rol
        Route::get('/roles/{role}/permisos', [PersonalController::class, 'permisos'])->middleware('can:roles_puestos.gestionar')->name('personal.permisos');
        Route::put('/roles/{role}/permisos', [PersonalController::class, 'updatePermisos'])->middleware('can:roles_puestos.gestionar')->name('personal.permisos.update');

        Route::post('/grados', [GrupoController::class, 'storeGrado'])->name('grados.store');
    });
});