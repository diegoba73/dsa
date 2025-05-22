<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockreactivosTable extends Migration
{
    public function up()
    {
        Schema::create('stockreactivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('registro')->nullable()->default('NULL');
            $table->date('fecha_entrada')->nullable()->default('NULL');
            $table->date('fecha_apertura')->nullable()->default('NULL');
            $table->date('fecha_vencimiento')->nullable()->default('NULL');
            $table->date('fecha_baja')->nullable()->default('NULL');
            $table->string('contenido')->nullable()->default('NULL');
            $table->string('marca')->nullable()->default('NULL');
            $table->string('grado')->nullable()->default('NULL');
            $table->string('lote')->nullable()->default('NULL');
            $table->string('conservacion')->nullable()->default('NULL');
            $table->string('almacenamiento')->nullable()->default('NULL');
            $table->integer('hs')->nullable()->default('NULL');
            $table->string('observaciones')->nullable()->default('NULL');
            $table->string('codigo_barra')->nullable()->default('NULL');
            $table->string('pedido')->nullable()->default('NULL');
            $table->integer('proveedor_id')->nullable(false);
            $table->integer('reactivo_id')->nullable(false);
            $table->string('area')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stockreactivos');
    }
}
