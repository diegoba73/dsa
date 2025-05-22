<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoReactivoTable extends Migration
{
    public function up()
    {
        Schema::create('pedido_reactivo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('reactivo_id')->nullable(false);
            $table->integer('pedido_id')->nullable(false);
            $table->string('cantidad_pedida')->nullable()->default('NULL');
            $table->string('cantidad_entregada')->nullable()->default('NULL');
            $table->string('costo_total')->nullable()->default('NULL');
            $table->string('observaciones')->nullable()->default('NULL');
            $table->integer('aceptado')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido_reactivo');
    }
}
