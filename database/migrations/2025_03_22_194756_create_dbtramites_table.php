<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbtramitesTable extends Migration
{
    public function up()
    {
        Schema::create('dbtramites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->date('fecha_inicio')->nullable(false);
            $table->string('tipo_tramite')->nullable(false);
            $table->string('estado')->nullable(false);
            $table->string('area')->nullable()->default('NULL');
            $table->string('observaciones')->nullable()->default('NULL');
            $table->integer('finalizado')->nullable()->default('NULL');
            $table->timestamp('created_at')->nullable(false)->default('CURRENT_TIMESTAMP');
            $table->timestamp('updated_at')->nullable(false)->default('CURRENT_TIMESTAMP');
            $table->integer('dbempresa_id')->nullable(false);
            $table->integer('dbredb_id')->nullable()->default('NULL');
            $table->integer('factura_id')->nullable()->default('NULL');
            $table->integer('dbrpadb_id')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbtramites');
    }
}
