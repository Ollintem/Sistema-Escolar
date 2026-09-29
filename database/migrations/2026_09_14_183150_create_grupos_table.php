<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id('id_grupo');
            $table->string('nombre');
            $table->string('nivel')->default('Primaria');
            $table->string('aula')->nullable();
            $table->unsignedBigInteger('id_docente')->nullable();
            $table->string('estado_cupo')->default('Completo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};