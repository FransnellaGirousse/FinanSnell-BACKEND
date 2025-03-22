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
            $table->string('key_company')->nullable()->after('final_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_in_advances', function (Blueprint $table) {
            $table->dropColumn('key_company');
        });
    }
};
