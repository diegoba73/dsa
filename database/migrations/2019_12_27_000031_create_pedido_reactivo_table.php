<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoReactivoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'pedido_reactivo';

    /**
     * Run the migrations.
     * @table pedido_reactivo
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('reactivo_id');
            $table->unsignedInteger('pedido_id');
            $table->string('cantidad_pedida', 45)->nullable();
            $table->tinyInteger('entrega_parcial')->nullable();
            $table->string('cantidad_entregada', 45)->nullable();
            $table->string('costo_total', 45)->nullable();
            $table->string('observaciones')->nullable();

            $table->index(["reactivo_id"], 'fk_pedido_reactivo_reactivos1_idx');

            $table->index(["pedido_id"], 'fk_pedido_reactivo_pedidos1_idx');


            $table->foreign('reactivo_id', 'fk_pedido_reactivo_reactivos1_idx')
                ->references('id')->on('reactivos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('pedido_id', 'fk_pedido_reactivo_pedidos1_idx')
                ->references('id')->on('pedidos')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
