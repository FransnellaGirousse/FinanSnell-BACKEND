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
        Schema::table('request_in_advances', function (Blueprint $table) {

            Schema::table('request_in_advances', function (Blueprint $table) {
            $table->decimal('final_total', 30, 2)->change();
        });
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_in_advances', function (Blueprint $table) {
             Schema::table('request_in_advances', function (Blueprint $table) {
            $table->decimal('final_total', 30, 2)->change();
        });
        });
    }
};
