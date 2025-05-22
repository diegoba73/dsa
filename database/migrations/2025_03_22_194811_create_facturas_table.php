<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('remitentes_id')->nullable(false);
            $table->dateTime('fecha_emision')->nullable()->default('NULL');
            $table->dateTime('fecha_vencimiento')->nullable()->default('NULL');
            $table->string('estado')->nullable()->default('NULL');
            $table->string('total')->nullable()->default('NULL');
            $table->integer('muestra')->nullable()->default('NULL');
            $table->string('fecha_pago')->nullable()->default('NULL');
            $table->string('nombre')->nullable()->default('NULL');
            $table->string('ruta')->nullable()->default('NULL');
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->integer('users_id')->nullable(false);
            $table->integer('departamento_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
