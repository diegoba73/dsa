<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturacionsTable extends Migration
{
    public function up()
    {
        Schema::create('facturacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->date('fecha_emision')->nullable()->default('NULL');
            $table->string('depositante')->nullable()->default('NULL');
            $table->string('detalle')->nullable()->default('NULL');
            $table->string('importe')->nullable(false);
            $table->string('departamento')->nullable()->default('NULL');
            $table->date('fecha_pago')->nullable()->default('NULL');
            $table->string('codigo_barra')->nullable()->default('NULL');
            $table->integer('user_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturacions');
    }
}
