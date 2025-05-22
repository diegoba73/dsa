<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemitentesTable extends Migration
{
    public function up()
    {
        Schema::create('remitentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('nombre')->nullable()->default('NULL');
            $table->string('cuit')->nullable()->default('NULL');
            $table->string('responsable')->nullable()->default('NULL');
            $table->string('area')->nullable()->default('NULL');
            $table->string('email')->nullable()->default('NULL');
            $table->string('direccion')->nullable()->default('NULL');
            $table->string('telefono')->nullable()->default('NULL');
            $table->integer('localidad_id')->nullable(false);
            $table->integer('user_id')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('remitentes');
    }
}
