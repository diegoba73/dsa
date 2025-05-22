<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalidadsTable extends Migration
{
    public function up()
    {
        Schema::create('localidads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('codigo_postal')->nullable()->default('NULL');
            $table->string('localidad')->nullable()->default('NULL');
            $table->integer('provincia_id')->nullable(false);
            $table->string('zona')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('localidads');
    }
}
