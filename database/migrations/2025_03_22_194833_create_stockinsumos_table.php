<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockinsumosTable extends Migration
{
    public function up()
    {
        Schema::create('stockinsumos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('registro')->nullable()->default('NULL');
            $table->date('fecha_entrada')->nullable()->default('NULL');
            $table->date('fecha_baja')->nullable()->default('NULL');
            $table->string('cantidad')->nullable()->default('NULL');
            $table->string('marca')->nullable()->default('NULL');
            $table->string('almacenamiento')->nullable()->default('NULL');
            $table->string('certificado')->nullable()->default('NULL');
            $table->string('observaciones')->nullable()->default('NULL');
            $table->string('codigo_barra')->nullable()->default('NULL');
            $table->string('pedido')->nullable()->default('NULL');
            $table->integer('proveedor_id')->nullable(false);
            $table->integer('insumo_id')->nullable(false);
            $table->string('area')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stockinsumos');
    }
}
