<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbinspeccionsTable extends Migration
{
    public function up()
    {
        Schema::create('dbinspeccions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->date('fecha')->nullable(false);
            $table->string('establecimiento')->nullable(false);
            $table->string('direccion')->nullable()->default('NULL');
            $table->string('rubro')->nullable()->default('NULL');
            $table->string('motivo')->nullable(false);
            $table->string('detalle')->nullable(false);
            $table->string('higiene')->nullable(false);
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->integer('user_id')->nullable(false);
            $table->integer('localidad_id')->nullable()->default('NULL');
            $table->integer('dbredb_id')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbinspeccions');
    }
}
