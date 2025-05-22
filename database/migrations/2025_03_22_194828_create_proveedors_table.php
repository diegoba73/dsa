<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorsTable extends Migration
{
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('empresa')->nullable(false);
            $table->string('contacto')->nullable()->default('NULL');
            $table->string('direccion')->nullable()->default('NULL');
            $table->string('telefono')->nullable()->default('NULL');
            $table->string('email')->nullable()->default('NULL');
            $table->string('tipo_insumo')->nullable()->default('NULL');
            $table->string('criticidad')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedors');
    }
}
