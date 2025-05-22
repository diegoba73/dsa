<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnsayosTable extends Migration
{
    public function up()
    {
        Schema::create('ensayos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('codigo')->nullable()->default('NULL');
            $table->string('tipo_ensayo')->nullable()->default('NULL');
            $table->string('ensayo')->nullable()->default('NULL');
            $table->string('metodo')->nullable()->default('NULL');
            $table->string('norma_procedimiento')->nullable()->default('NULL');
            $table->string('unidades')->nullable()->default('NULL');
            $table->string('valor_referencia')->default('0');
            $table->string('limite_d')->nullable()->default('NULL');
            $table->string('limite_c')->nullable()->default('NULL');
            $table->integer('costo')->nullable()->default('NULL');
            $table->integer('activo')->nullable()->default('NULL');
            $table->integer('matriz_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ensayos');
    }
}
