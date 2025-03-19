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
        Schema::table('assignment_oms', function (Blueprint $table) {
            // Supprimer uniquement la colonne tdr_id
            if (Schema::hasColumn('assignment_oms', 'tdr_id')) {
                $table->dropColumn('tdr_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignment_oms', function (Blueprint $table) {
            // Recréer la colonne tdr_id si nécessaire
            $table->unsignedBigInteger('tdr_id');
            $table->foreign('tdr_id')
                  ->references('id')
                  ->on('create_tdr')
                  ->onDelete('cascade');
        });
    }
};
