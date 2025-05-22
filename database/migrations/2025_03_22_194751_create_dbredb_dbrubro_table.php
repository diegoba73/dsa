<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbredbDbrubroTable extends Migration
{
    public function up()
    {
        Schema::create('dbredb_dbrubro', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('dbredb_id')->nullable(false);
            $table->integer('dbcategoria_id')->nullable(false);
            $table->integer('dbrubro_id')->nullable(false);
            $table->string('actividad')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbredb_dbrubro');
    }
}
