<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNomencladorsOldTable extends Migration
{
    public function up()
    {
        Schema::create('nomencladors_old', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('descripcion')->nullable(false);
            $table->integer('valor')->nullable()->default('NULL');
            $table->integer('departamento_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nomencladors_old');
    }
}
