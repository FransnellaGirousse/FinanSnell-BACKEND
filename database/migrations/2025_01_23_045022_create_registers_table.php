<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname'); // Prénom
            $table->string('lastname');  // Nom
            $table->string('email')->unique(); // Email
            $table->string('password'); // Mot de passe
            $table->string('role')->default('user'); // Rôle (par défaut : user)
            $table->string('phone_number')->nullable(); // Numéro de téléphone
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
