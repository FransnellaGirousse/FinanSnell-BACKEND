<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('create_tdr', function (Blueprint $table) {
            $table->string('status')->default('En attente')->after('mission_title');
        });
    }

    public function down(): void
    {
        Schema::table('create_tdr', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
