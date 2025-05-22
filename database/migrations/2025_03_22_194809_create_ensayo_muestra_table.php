<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnsayoMuestraTable extends Migration
{
    public function up()
    {
        Schema::create('ensayo_muestra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->date('fecha_inicio')->nullable()->default('NULL');
            $table->date('fecha_fin')->nullable()->default('NULL');
            $table->string('resultado')->nullable()->default('NULL');
            $table->integer('ensayo_id')->nullable(false);
            $table->integer('muestra_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ensayo_muestra');
    }
}
