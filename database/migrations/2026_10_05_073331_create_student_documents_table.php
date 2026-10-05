<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alumno');
            $table->string('tipo_documento'); // 'Acta de Nacimiento', 'CURP', etc.
            $table->string('ruta_archivo');
            $table->string('extension', 10)->nullable();
            $table->timestamp('fecha_carga')->nullable();
            $table->timestamps();

            // Llave foránea que conecta con la tabla alumnos
            $table->foreign('id_alumno')->references('id_alumno')->on('alumnos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_documents');
    }
};