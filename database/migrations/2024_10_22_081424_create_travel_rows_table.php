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
        Schema::create('travel_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_in_advance_id')->constrained('request_in_advances')->onDelete('cascade'); // Clé étrangère

            $table->string('location');
            $table->string('per_diem_rate');
            $table->string('percentage_of_advance_required');
            $table->string('number_of_days');
            $table->string('total_amount');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_rows');
    }
};
