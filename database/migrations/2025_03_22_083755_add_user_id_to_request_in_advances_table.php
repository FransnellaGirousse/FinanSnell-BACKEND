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
        if (!Schema::hasColumn('request_in_advances', 'user_id')) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id'); // nullable
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_in_advances', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

        });
    }
};
