<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbredbsTable extends Migration
{
    public function up()
    {
        Schema::create('dbredbs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('numero')->nullable()->default('NULL');
            $table->string('establecimiento')->nullable(false);
            $table->string('domicilio')->nullable(false);
            $table->date('fecha_inscripcion')->nullable()->default('NULL');
            $table->date('fecha_baja')->nullable()->default('NULL');
            $table->date('fecha_reinscripcion')->nullable()->default('NULL');
            $table->date('fecha_modificacion')->nullable()->default('NULL');
            $table->string('ruta_analisis')->nullable()->default('NULL');
            $table->string('ruta_memoria')->nullable()->default('NULL');
            $table->string('ruta_contrato')->nullable()->default('NULL');
            $table->string('ruta_habilitacion')->nullable()->default('NULL');
            $table->string('ruta_plano')->nullable()->default('NULL');
            $table->string('ruta_acta')->nullable()->default('NULL');
            $table->string('ruta_pago')->nullable()->default('NULL');
            $table->string('ruta_vinculaciondt')->nullable()->default('NULL');
            $table->integer('finalizado')->nullable()->default('NULL');
            $table->string('expediente')->nullable()->default('NULL');
            $table->string('transito')->nullable(false);
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->integer('user_id')->nullable(false);
            $table->integer('dbdt_id')->nullable()->default('NULL');
            $table->integer('dbempresa_id')->nullable(false);
            $table->integer('dbbaja_id')->nullable()->default('NULL');
            $table->integer('localidad_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbredbs');
    }
}
