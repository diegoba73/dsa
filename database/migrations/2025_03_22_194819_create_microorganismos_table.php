<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicroorganismosTable extends Migration
{
    public function up()
    {
        Schema::create('microorganismos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->string('numero')->nullable(false);
            $table->string('microorganismo')->nullable(false);
            $table->string('medio_cultivo')->nullable()->default('NULL');
            $table->string('condiciones')->nullable()->default('NULL');
            $table->string('tsi')->nullable()->default('NULL');
            $table->string('citrato')->nullable()->default('NULL');
            $table->string('lia')->nullable()->default('NULL');
            $table->string('urea')->nullable()->default('NULL');
            $table->string('sim')->nullable()->default('NULL');
            $table->string('esculina')->nullable()->default('NULL');
            $table->string('hemolisis')->nullable()->default('NULL');
            $table->string('tumbling')->nullable()->default('NULL');
            $table->string('fluorescencia')->nullable()->default('NULL');
            $table->string('coagulasa')->nullable()->default('NULL');
            $table->string('oxidasa')->nullable()->default('NULL');
            $table->string('catalasa')->nullable()->default('NULL');
            $table->string('gram')->nullable()->default('NULL');
            $table->string('observaciones')->nullable()->default('NULL');
            $table->integer('proveedor_id')->nullable(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('microorganismos');
    }
}
