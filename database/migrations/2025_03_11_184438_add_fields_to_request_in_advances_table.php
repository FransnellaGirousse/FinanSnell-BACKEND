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
        $table->integer('number_of_days')->after('account_number');
        $table->decimal('total_general', 10, 2)->after('number_of_days');
        $table->decimal('final_total', 10, 2)->after('total_general');
    });
}

public function down(): void
{
    Schema::table('request_in_advances', function (Blueprint $table) {
        $table->dropColumn(['number_of_days', 'total_general', 'final_total']);
    });
}

};
