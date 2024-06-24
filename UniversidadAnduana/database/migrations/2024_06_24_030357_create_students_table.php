<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->unsignedBigInteger('career_id'); // Debe ser del mismo tipo que el campo referenciado en `careers`
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });        
        
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}

