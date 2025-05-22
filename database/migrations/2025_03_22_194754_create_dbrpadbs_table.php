<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbrpadbsTable extends Migration
{
    public function up()
    {
        Schema::create('dbrpadbs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('numero')->nullable()->default('NULL');
            $table->string('denominacion')->nullable(false);
            $table->string('nombre_fantasia')->nullable()->default('NULL');
            $table->string('marca')->nullable(false);
            $table->date('fecha_inscripcion')->nullable()->default('NULL');
            $table->string('articulo_caa')->nullable()->default('NULL');
            $table->date('fecha_reinscripcion')->nullable()->default('NULL');
            $table->date('fecha_modificacion')->nullable()->default('NULL');
            $table->date('fecha_baja')->nullable()->default('NULL');
            $table->string('ruta_analisis')->nullable()->default('NULL');
            $table->string('ruta_ingredientes')->nullable()->default('NULL');
            $table->string('ruta_especificaciones')->nullable()->default('NULL');
            $table->string('ruta_monografia')->nullable()->default('NULL');
            $table->string('ruta_infonut')->nullable()->default('NULL');
            $table->string('ruta_rotulo')->nullable()->default('NULL');
            $table->string('ruta_certenvase')->nullable()->default('NULL');
            $table->string('ruta_pago')->nullable()->default('NULL');
            $table->integer('dbbaja_id')->nullable()->default('NULL');
            $table->integer('iniciado')->nullable()->default('NULL');
            $table->integer('finalizado')->nullable()->default('NULL');
            $table->string('expediente')->nullable()->default('NULL');
            $table->timestamp('created_at')->nullable()->default('CURRENT_TIMESTAMP');
            $table->timestamp('updated_at')->nullable()->default('CURRENT_TIMESTAMP');
            $table->integer('dbredb_id')->nullable(false);
            $table->integer('dbempresa_id')->nullable(false);
            $table->integer('user_id')->nullable(false);
            $table->integer('dbredb_dbrubro_id')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbrpadbs');
    }
}
