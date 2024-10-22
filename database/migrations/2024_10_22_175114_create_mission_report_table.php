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
        Schema::create('mission_reports', function (Blueprint $table) {
            $table->id();
            $table->date('date'); 
            $table->string('name_of_missionary'); 
            $table->string('object'); 
            $table->text('mission_objectives'); 
            $table->string('mission_location'); 
            $table->text('next_steps'); 
            $table->text('point_to_improve'); 
            $table->text('strong_points'); 
            $table->text('recommendations'); 
            $table->text('progress_of_activities'); 

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_reports');
    }
};
