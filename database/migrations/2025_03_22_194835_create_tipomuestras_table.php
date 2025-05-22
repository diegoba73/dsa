<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipomuestrasTable extends Migration
{
    public function up()
    {
        Schema::create('tipomuestras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('tipo_muestra')->nullable(false);
            $table->integer('matriz_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipomuestras');
    }
}
