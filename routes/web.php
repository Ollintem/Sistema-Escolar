<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CicloEscolarController;
use App\Http\Controllers\GrupoController; // <-- Importante incluir esta línea
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';
Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Dashboard y perfil
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulo Alumnos
    Route::resource('alumnos', AlumnoController::class);

    // Módulo Ciclos Escolares
    Route::get('/ciclos', [CicloEscolarController::class, 'index'])->name('ciclos.index');
    Route::post('/ciclos', [CicloEscolarController::class, 'store'])->name('ciclos.store');
    Route::patch('/ciclos/{id}/toggle', [CicloEscolarController::class, 'toggleEstado'])->name('ciclos.toggle');

    // Módulo Grupos (Task 2.1)
    Route::get('/grupos', [GrupoController::class, 'index'])->name('grupos.index');
    Route::post('/grupos', [GrupoController::class, 'store'])->name('grupos.store');

    // Módulos restantes
    Route::view('/docentes', 'docentes.index')->name('docentes.index');
    Route::view('/boletas', 'boletas.index')->name('boletas.index');
});