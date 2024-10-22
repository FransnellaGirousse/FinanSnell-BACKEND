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
    if (!Schema::hasTable('request_in_advances')) {
        Schema::create('request_in_advances', function (Blueprint $table) {
            $table->id();
            $table->string('social_security_number');
            $table->string('nationality');
            $table->string('address');
            $table->date('date_need_by');
            $table->date('date_requested');
            $table->string('special_mailing_instruction');
            $table->string('purpose_of_travel');
            $table->string('destination');
            $table->string('location');
            $table->string('per_diem_rate');
            $table->string('daily_rating_coefficient');
            $table->string('percentage_of_advance_required');
            $table->string('total_amount');
            $table->string('additional_costs_motif');
            $table->string('additional_costs');
            $table->string('total_sum');
            $table->decimal('amount_requested', 10, 2);
            $table->string('bank');
            $table->string('branch');
            $table->string('name');
            $table->string('account_number');
            $table->string('signature');
            $table->timestamps();
        });
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_in_advances');
    }
};
