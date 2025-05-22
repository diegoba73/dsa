<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumosTable extends Migration
{
    public function up()
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('codigo')->nullable()->default('NULL');
            $table->string('nombre')->nullable()->default('NULL');
            $table->string('descripcion')->nullable()->default('NULL');
            $table->integer('cromatografia')->nullable()->default('NULL');
            $table->integer('quimica_al')->nullable()->default('NULL');
            $table->integer('quimica_ag')->nullable()->default('NULL');
            $table->integer('ensayo_biologico')->nullable()->default('NULL');
            $table->integer('microbiologia')->nullable()->default('NULL');
            $table->integer('costo')->nullable()->default('NULL');
            $table->date('fecha_cotizacion')->nullable()->default('NULL');
            $table->string('proveedor_cotizo')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insumos');
    }
}
