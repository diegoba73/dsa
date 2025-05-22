<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbenvasesTable extends Migration
{
    public function up()
    {
        Schema::create('dbenvases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('tipo_envase')->nullable(false);
            $table->string('material')->nullable(false);
            $table->string('contenido_neto')->nullable()->default('NULL');
            $table->string('contenido_escurrido')->nullable()->default('NULL');
            $table->string('lapso_aptitud')->nullable()->default('NULL');
            $table->string('condiciones_conservacion')->nullable()->default('NULL');
            $table->string('ruta_cert_envase')->nullable()->default('NULL');
            $table->integer('dbrpadb_id')->nullable(false);
            $table->timestamp('created_at')->nullable(false)->default('CURRENT_TIMESTAMP');
            $table->timestamp('updated_at')->nullable(false)->default('CURRENT_TIMESTAMP');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbenvases');
    }
}
