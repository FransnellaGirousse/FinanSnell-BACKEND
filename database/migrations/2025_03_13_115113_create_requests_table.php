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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('social_security_number');
            $table->string('nationality');
            $table->string('address');
            $table->date('date_need_by');
            $table->date('date_requested');
            $table->text('special_mailing_instruction')->nullable();
            $table->string('purpose_of_travel');
            $table->string('destination');
            $table->string('location');
            $table->decimal('per_diem_rate', 8, 2);
            $table->decimal('daily_rating_coefficient', 8, 2);
            $table->decimal('percentage_of_advance_required', 5, 2);
            $table->decimal('total_amount', 10, 2);
            $table->text('additional_costs_motif')->nullable();
            $table->decimal('additional_costs', 10, 2)->nullable();
            $table->decimal('total_sum', 10, 2);
            $table->decimal('amount_requested', 10, 2);
            $table->string('bank');
            $table->string('branch');
            $table->string('name');
            $table->string('account_number');
            $table->integer('number_of_days');
            $table->decimal('total_general', 10, 2);
            $table->decimal('final_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
