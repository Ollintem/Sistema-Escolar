<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla de Materias (Task 1.2)
        Schema::create('subjects', function (Blueprint $table) {
            $table->id('id_materia');
            $table->string('nombre');
            $table->string('clave')->unique();
            $table->timestamps();
        });

        // Tabla de Grupos (Task 1.2 & 2.1)
        Schema::create('groups', function (Blueprint $table) {
            $table->id('id_grupo');
            $table->string('grado');
            $table->string('grupo');
            $table->string('turno')->default('Matutino');
            $table->foreignId('id_ciclo')->nullable();
            $table->foreignId('docente_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Tabla Pivote: Grupo - Materias
        Schema::create('group_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups', 'id_grupo')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects', 'id_materia')->onDelete('cascade');
        });

        // Tabla de Alumnos (Task 1.2 & 2.2)
        Schema::create('students', function (Blueprint $table) {
            $table->id('id_alumno');
            $table->string('matricula')->unique();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('curp')->unique();
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro']);
            $table->string('foto')->nullable();
            
            // Datos Médicos
            $table->string('tipo_sangre')->nullable();
            $table->text('alergias')->nullable();
            $table->text('observaciones_medicas')->nullable();

            // Datos Tutor
            $table->string('tutor_nombre');
            $table->string('tutor_parentesco');
            $table->string('tutor_telefono');
            $table->string('tutor_email');

            // Adscripción Académica
            $table->foreignId('id_ciclo')->nullable();
            $table->foreignId('id_grupo')->nullable()->constrained('groups', 'id_grupo')->onDelete('set null');
            $table->enum('estado', ['Activo', 'Inactivo', 'Baja'])->default('Activo');
            $table->boolean('expediente_completo')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('group_subject');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('subjects');
    }
};