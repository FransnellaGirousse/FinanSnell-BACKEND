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
        Schema::table('assignment_oms', function (Blueprint $table) {
            $table->dropColumn([
                'date_hour',
                'starting_point',
                'destination',
                'authorization_airfare',
                'fund_speedkey',
                'price'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignment_oms', function (Blueprint $table) {
            $table->timestamp('date_hour')->nullable();
            $table->string('starting_point')->nullable();
            $table->string('destination')->nullable();
            $table->string('authorization_airfare')->nullable();
            $table->string('fund_speedkey')->nullable();
            $table->string('price')->nullable();
        });
    }
};
