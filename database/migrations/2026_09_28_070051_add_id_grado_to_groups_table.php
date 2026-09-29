<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->foreignId('id_grado')->nullable()->after('id_grupo')->constrained('grados', 'id_grado')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['id_grado']);
            $table->dropColumn('id_grado');
        });
    }
};