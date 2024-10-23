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
        Schema::create('create_tdr', function (Blueprint $table) {
            $table->id();
            $table->string('mission_title');
            $table->text('introduction');
            $table->text('mission_objectives');
            $table->text('planned_activities');
            $table->text('necessary_resources');
            $table->text('conclusion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_tdr');
    }
};
