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
    Schema::create('calificaciones', function (Blueprint $table) {
        $table->id('id_calificacion');
        $table->foreignId('id_alumno')->constrained('alumnos', 'id_alumno')->onDelete('cascade');
        $table->foreignId('id_materia')->constrained('materias', 'id_materia')->onDelete('cascade');
        $table->foreignId('id_docente')->constrained('docentes', 'id_docente')->onDelete('cascade');
        $table->decimal('parcial_1', 4, 2)->nullable();
        $table->decimal('parcial_2', 4, 2)->nullable();
        $table->decimal('parcial_3', 4, 2)->nullable();
        $table->decimal('calificacion_final', 4, 2)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacions');
    }
};
