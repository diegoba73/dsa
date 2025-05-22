<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaNomencladorTable extends Migration
{
    public function up()
    {
        Schema::create('factura_nomenclador', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('factura_id')->nullable(false);
            $table->integer('nomenclador_id')->nullable(false);
            $table->string('cantidad')->nullable()->default('NULL');
            $table->string('subtotal')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factura_nomenclador');
    }
}
