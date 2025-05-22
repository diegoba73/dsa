<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCepasTable extends Migration
{
    public function up()
    {
        Schema::create('cepas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('microorganismo_id')->nullable(false);
            $table->string('lote')->nullable(false);
            $table->date('fecha_incubacion')->nullable(false);
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
            $table->string('codigo_barra')->nullable()->default('NULL');
            $table->integer('user_id')->nullable(false);
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cepas');
    }
}
