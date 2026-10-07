<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id('id_asistencia');
            $table->foreignId('id_alumno')->constrained('alumnos', 'id_alumno')->onDelete('cascade');
            $table->foreignId('id_grupo')->constrained('groups', 'id_grupo')->onDelete('cascade');
            $table->foreignId('id_materia')->nullable()->constrained('subjects', 'id_materia')->onDelete('set null');
            $table->date('fecha');
            $table->enum('estatus', ['P', 'F', 'R', 'J'])->default('P'); // Presente, Falta, Retardo, Justificado
            $table->string('observacion')->nullable();
            $table->timestamps();

            // Clave única para evitar pases de lista duplicados en el mismo día/materia
            $table->unique(['id_alumno', 'id_materia', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};