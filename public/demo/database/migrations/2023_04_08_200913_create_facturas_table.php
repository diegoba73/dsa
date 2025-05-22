<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('remitentes_id');
            $table->foreign('remitentes_id')->references('id')->on('remitentes')->onDelete('cascade');
            $table->datetime('fecha_emision')->nullable();
            $table->datetime('fecha_vencimiento')->nullable();
            $table->string('estado', 45)->nullable();
            $table->string('total', 45)->nullable();
            $table->string('fecha_pago', 45)->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
