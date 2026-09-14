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
    Schema::create('ciclos_escolares', function (Blueprint $table) {
        $table->id('id_ciclo');
        $table->string('nombre');
        $table->date('fecha_inicio');
        $table->date('fecha_fin');
        $table->string('estado');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclo_escolars');
    }
};
