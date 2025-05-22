<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('nro_pedido')->nullable(false);
            $table->date('fecha_pedido')->nullable()->default('NULL');
            $table->string('descripcion')->nullable()->default('NULL');
            $table->string('estado')->nullable()->default('NULL');
            $table->date('fecha_expediente')->nullable()->default('NULL');
            $table->string('nro_nota')->nullable()->default('NULL');
            $table->string('nro_expediente')->nullable()->default('NULL');
            $table->integer('finalizado')->nullable()->default('NULL');
            $table->integer('baja')->nullable()->default('NULL');
            $table->integer('entrega_parcial')->nullable()->default('NULL');
            $table->string('observaciones')->nullable()->default('NULL');
            $table->string('costo_total')->nullable()->default('NULL');
            $table->integer('user_id')->nullable(false);
            $table->integer('departamento_id')->nullable(false);
            $table->integer('dsaexpediente_id')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
