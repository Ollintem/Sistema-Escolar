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
    Schema::create('alumnos', function (Blueprint $table) {
        $table->id('id_alumno');
        $table->string('nombre');
        $table->string('apellido_p');
        $table->string('apellido_m');
        $table->date('fecha_nacimiento');
        $table->string('curp')->unique();
        $table->string('correo')->unique();
        $table->string('telefono');
        $table->foreignId('id_grupo')->nullable()->constrained('grupos', 'id_grupo')->onDelete('set null');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
