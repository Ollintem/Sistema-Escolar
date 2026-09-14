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
    Schema::create('documentos', function (Blueprint $table) {
        $table->id('id_documento');
        $table->foreignId('id_alumno')->constrained('alumnos', 'id_alumno')->onDelete('cascade');
        $table->string('tipo');
        $table->string('ruta');
        $table->date('fecha_subida');
        $table->string('estado');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
