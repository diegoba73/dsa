<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsaexpedientesTable extends Migration
{
    public function up()
    {
        Schema::create('dsaexpedientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('nro_nota')->nullable()->default('NULL');
            $table->string('nro_expediente')->nullable()->default('NULL');
            $table->string('descripcion')->nullable()->default('NULL');
            $table->date('fecha_expediente')->nullable()->default('NULL');
            $table->string('estado')->nullable()->default('NULL');
            $table->string('observaciones')->nullable()->default('NULL');
            $table->string('costo_total')->nullable()->default('NULL');
            $table->integer('users_id')->nullable(false);
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dsaexpedientes');
    }
}
