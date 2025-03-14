<?php

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\clear;

class CreateUsersTable extends Migration  
{  
    public function up()  
    {  
        Schema::create('users', function (Blueprint $table) {  
            $table->id();  
            $table->string('firstname');  
            $table->string('lastname');  
            $table->string('email')->unique();  
            $table->string('password');  
            $table->string('phone_number')->nullable();  
            $table->string('role');
            $table->timestamps();  
        });  
    }  

    public function down()  
    {  
        Schema::dropIfExists('users');  
    }  
}
