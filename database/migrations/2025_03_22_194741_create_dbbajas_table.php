<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbbajasTable extends Migration
{
    public function up()
    {
        Schema::create('dbbajas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('numero')->nullable(false);
            $table->string('caja')->nullable(false);
            $table->text('fecha_baja')->nullable(false);
            $table->string('motivo')->nullable(false);
            $table->string('expediente')->nullable(false);
            $table->string('nro_registro')->nullable(false);
            $table->string('establecimiento')->nullable(false);
            $table->string('solicito')->nullable(false);
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->integer('user_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbbajas');
    }
}
