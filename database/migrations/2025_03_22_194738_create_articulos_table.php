<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('item')->nullable()->default('NULL');
            $table->string('cantidad')->nullable()->default('NULL');
            $table->string('cantidad_entregada')->nullable()->default('NULL');
            $table->string('precio')->nullable()->default('NULL');
            $table->integer('pedido_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
