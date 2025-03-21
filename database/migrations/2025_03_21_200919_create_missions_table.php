<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('traveler');
            $table->string('purpose_of_the_mission');
            $table->timestamp('date_hour');
            $table->string('starting_point');
            $table->string('destination');
            $table->string('authorization_airfare');
            $table->string('fund_speedkey');
            $table->string('price');
            $table->string('name_of_the_hotel');
            $table->string('room_rate');
            $table->integer('confirmation_number');
            $table->date('date_hotel');
            $table->text('other_details_hotel')->nullable();
            $table->text('other_logistical_requirments')->nullable();
            $table->unsignedBigInteger('tdr_id');
            $table->foreign('tdr_id')->references('id')->on('create_tdr')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
