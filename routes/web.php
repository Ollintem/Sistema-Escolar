<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirección inicial al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas generadas por Laravel UI / Breeze
require __DIR__.'/auth.php';
Auth::routes();

// Grupo de rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Panel Principal
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Vistas principales del Sidebar
    Route::view('/ciclos', 'ciclos.index')->name('ciclos.index');
    Route::view('/alumnos', 'alumnos.index')->name('alumnos.index');
    Route::view('/docentes', 'docentes.index')->name('docentes.index');
    Route::view('/boletas', 'boletas.index')->name('boletas.index');
});
