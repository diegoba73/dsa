<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrasesTable extends Migration
{
    public function up()
    {
        Schema::create('frases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('frase')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('frases');
    }
}
