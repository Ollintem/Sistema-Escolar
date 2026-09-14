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
    Schema::create('grupos', function (Blueprint $table) {
        $table->id('id_grupo');
        $table->string('nombre');
        $table->string('turno');
        $table->foreignId('id_grado')->constrained('grados', 'id_grado')->onDelete('cascade');
        $table->foreignId('id_ciclo')->constrained('ciclos_escolares', 'id_ciclo')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
