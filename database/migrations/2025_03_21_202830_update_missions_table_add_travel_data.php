<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            // Ajouter le champ JSON
            $table->json('travel_data')->nullable();

            // Supprimer les anciens champs
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

    public function down(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            // Remettre les anciens champs
            $table->timestamp('date_hour');
            $table->string('starting_point');
            $table->string('destination');
            $table->string('authorization_airfare');
            $table->string('fund_speedkey');
            $table->string('price');

            // Supprimer le champ travel_data
            $table->dropColumn('travel_data');
        });
    }
};
