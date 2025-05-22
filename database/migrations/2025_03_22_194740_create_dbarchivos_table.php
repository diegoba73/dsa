<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbarchivosTable extends Migration
{
    public function up()
    {
        Schema::create('dbarchivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('caja')->nullable(false);
            $table->string('establecimiento')->nullable(false);
            $table->string('descripcion')->nullable(false);
            $table->integer('user_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbarchivos');
    }
}
