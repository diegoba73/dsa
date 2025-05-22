<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbremitoMuestraTable extends Migration
{
    public function up()
    {
        Schema::create('dbremito_muestra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('dbremito_id')->nullable(false);
            $table->integer('muestra_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbremito_muestra');
    }
}
