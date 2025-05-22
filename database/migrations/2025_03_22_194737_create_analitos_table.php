<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalitosTable extends Migration
{
    public function up()
    {
        Schema::create('analitos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('analito')->nullable()->default('NULL');
            $table->string('valor_hallado')->nullable()->default('NULL');
            $table->string('unidad')->nullable()->default('NULL');
            $table->string('observaciones')->nullable()->default('NULL');
            $table->string('parametro_calidad')->nullable()->default('NULL');
            $table->integer('muestra_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('analitos');
    }
}
