<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesaentradasTable extends Migration
{
    public function up()
    {
        Schema::create('mesaentradas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('departamento_id')->nullable(false);
            $table->date('fecha_ingreso')->nullable(false);
            $table->string('descripcion')->nullable(false);
            $table->string('destino')->nullable()->default('NULL');
            $table->string('nro_nota_remitida')->nullable()->default('NULL');
            $table->string('nro_nota_respuesta')->nullable()->default('NULL');
            $table->string('usuario')->nullable()->default('NULL');
            $table->integer('finalizado')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mesaentradas');
    }
}
