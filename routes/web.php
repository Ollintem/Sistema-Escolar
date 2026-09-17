<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumnoController; // <-- Importante incluir esta línea
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

    // Cambiamos Route::view por el controlador para Alumnos
    Route::resource('alumnos', AlumnoController::class);

    // Las demás vistas estáticas del sidebar
    Route::view('/ciclos', 'ciclos.index')->name('ciclos.index');
    Route::view('/docentes', 'docentes.index')->name('docentes.index');
    Route::view('/boletas', 'boletas.index')->name('boletas.index');
});
