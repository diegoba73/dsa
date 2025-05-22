<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbdtsTable extends Migration
{
    public function up()
    {
        Schema::create('dbdts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('nombre')->nullable()->default('NULL');
            $table->string('dni')->nullable()->default('NULL');
            $table->string('titulo')->nullable()->default('NULL');
            $table->string('domicilio')->nullable()->default('NULL');
            $table->string('ciudad')->nullable()->default('NULL');
            $table->string('telefono')->nullable()->default('NULL');
            $table->string('email')->nullable()->default('NULL');
            $table->string('universidad')->nullable()->default('NULL');
            $table->string('matricula')->nullable()->default('NULL');
            $table->date('fecha_inscripcion')->nullable()->default('NULL');
            $table->date('fecha_reinscripcion')->nullable()->default('NULL');
            $table->timestamp('fecha_baja')->nullable()->default('NULL');
            $table->string('motivo_baja')->nullable()->default('NULL');
            $table->string('ruta_dni')->nullable()->default('NULL');
            $table->string('ruta_titulo')->nullable()->default('NULL');
            $table->string('ruta_cv')->nullable()->default('NULL');
            $table->string('ruta_cert_domicilio')->nullable()->default('NULL');
            $table->string('ruta_antecedentes')->nullable()->default('NULL');
            $table->string('ruta_arancel')->nullable()->default('NULL');
            $table->string('ruta_vinculacion')->nullable()->default('NULL');
            $table->string('ruta_foto')->nullable()->default('NULL');
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbdts');
    }
}
