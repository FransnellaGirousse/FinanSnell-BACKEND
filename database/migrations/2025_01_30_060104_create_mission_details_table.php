<?php

// database/migrations/YYYY_MM_DD_create_mission_details_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('mission_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_om_id')->constrained('assignment_oms')->onDelete('cascade');
            $table->dateTime('date_hour');
            $table->string('starting_point');
            $table->string('destination');
            $table->string('authorization_airfare');
            $table->string('fund_speedkey');
            $table->string('price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mission_details');
    }
}

