<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbempresasTable extends Migration
{
    public function up()
    {
        Schema::create('dbempresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('cuit')->nullable()->default('NULL');
            $table->string('empresa')->nullable(false);
            $table->string('domicilio')->nullable()->default('NULL');
            $table->string('ciudad')->nullable()->default('NULL');
            $table->string('provincia')->nullable()->default('NULL');
            $table->string('telefono')->nullable()->default('NULL');
            $table->string('email')->nullable()->default('NULL');
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->string('ruta_cuit')->nullable()->default('NULL');
            $table->string('ruta_dni')->nullable()->default('NULL');
            $table->string('ruta_estatuto')->nullable()->default('NULL');
            $table->integer('baja_id')->nullable()->default('NULL');
            $table->integer('user_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbempresas');
    }
}
