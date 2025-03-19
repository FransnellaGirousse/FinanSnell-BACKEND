<?php

// database/migrations/YYYY_MM_DD_add_assignment_om_id_to_mission_details_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignmentOmIdToMissionDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('mission_details', function (Blueprint $table) {
            $table->foreignId('assignment_om_id')->constrained('assignment_oms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('mission_details', function (Blueprint $table) {
            $table->dropForeign(['assignment_om_id']);
            $table->dropColumn('assignment_om_id');
        });
    }
}
