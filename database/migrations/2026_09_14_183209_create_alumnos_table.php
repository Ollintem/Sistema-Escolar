<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id('id_alumno');
            $table->string('nombre');
            $table->string('apellido_p');
            $table->string('apellido_m');
            $table->date('fecha_nacimiento');
            $table->string('curp')->unique();
            $table->string('correo')->unique();
            $table->string('telefono');
            
            // Foto
            $table->string('foto')->nullable();

            // Datos Médicos
            $table->string('tipo_sangre')->nullable();
            $table->string('alergias')->nullable();
            $table->string('observaciones_medicas')->nullable();

            // Datos del Tutor
            $table->string('tutor_nombre')->nullable();
            $table->string('tutor_parentesco')->nullable();
            $table->string('tutor_telefono')->nullable();
            $table->string('tutor_email')->nullable();

            // Relaciones y Datos Académicos
            $table->unsignedBigInteger('id_grupo')->nullable();
            $table->unsignedBigInteger('id_ciclo')->nullable();
            $table->string('grado')->nullable();
            $table->string('estado')->default('Activo');

            $table->timestamps();

            // Clave foránea a la tabla grupos
            $table->foreign('id_grupo')->references('id_grupo')->on('grupos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};