<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsbremitoMuestraTable extends Migration
{
    public function up()
    {
        Schema::create('dsbremito_muestra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('dsbremito_id')->nullable(false);
            $table->integer('muestra_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dsbremito_muestra');
    }
}
