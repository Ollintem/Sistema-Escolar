<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            // Eliminar FK anterior
            $table->dropForeign(['id_grupo']);
            
            // Recrear FK apuntando a la tabla 'groups'
            $table->foreign('id_grupo')
                  ->references('id_grupo')
                  ->on('groups')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropForeign(['id_grupo']);
            $table->foreign('id_grupo')
                  ->references('id_grupo')
                  ->on('grupos')
                  ->onDelete('set null');
        });
    }
};