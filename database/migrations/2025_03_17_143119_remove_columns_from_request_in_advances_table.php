<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('request_in_advances', function (Blueprint $table) {
            $table->dropColumn(['location', 'per_diem_rate', 'percentage_of_advance_required', 'total_amount']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_in_advances', function (Blueprint $table) {
            $table->string('location')->nullable();
            $table->string('per_diem_rate')->nullable();
            $table->string('percentage_of_advance_required')->nullable();
            $table->string('total_amount')->nullable();
        });
    }
};
