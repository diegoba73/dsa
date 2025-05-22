<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsanotasTable extends Migration
{
    public function up()
    {
        Schema::create('dsanotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('numero')->nullable()->default('NULL');
            $table->date('fecha')->nullable()->default('NULL');
            $table->string('descripcion')->nullable()->default('NULL');
            $table->integer('user_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dsanotas');
    }
}
