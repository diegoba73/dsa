<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsoremitosTable extends Migration
{
    public function up()
    {
        Schema::create('dsoremitos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->date('fecha')->nullable(false);
            $table->text('conclusion');
            $table->integer('nro_nota')->nullable()->default('NULL');
            $table->integer('chequeado')->nullable(false)->default('0');
            $table->date('fecha_salida')->nullable()->default('NULL');
            $table->integer('remitente_id')->nullable(false);
            $table->integer('user_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dsoremitos');
    }
}
