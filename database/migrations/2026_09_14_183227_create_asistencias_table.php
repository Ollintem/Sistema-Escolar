<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('asistencias', function (Blueprint $table) {
        $table->id('id_asistencia');
        $table->foreignId('id_alumno')->constrained('alumnos', 'id_alumno')->onDelete('cascade');
        $table->foreignId('id_materia')->constrained('materias', 'id_materia')->onDelete('cascade');
        $table->date('fecha');
        $table->string('estado');
        $table->string('observaciones')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
