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
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'google_id')) {
            $table->string('google_id')->nullable();
        }
    });
}


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id'); 
        });
    }
};