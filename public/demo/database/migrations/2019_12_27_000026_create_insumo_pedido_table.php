<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumoPedidoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'insumo_pedido';

    /**
     * Run the migrations.
     * @table insumo_pedido
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('insumo_id');
            $table->unsignedInteger('pedido_id');
            $table->string('cantidad_pedida', 45)->nullable();
            $table->tinyInteger('entrega_parcial')->nullable();
            $table->string('cantidad_entregada', 45)->nullable();
            $table->string('observaciones')->nullable();

            $table->index(["pedido_id"], 'fk_insumo_pedido_pedido1_idx');

            $table->index(["insumo_id"], 'fk_insumo_pedido_insumo1_idx');


            $table->foreign('insumo_id', 'fk_insumo_pedido_insumo1_idx')
                ->references('id')->on('insumos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('pedido_id', 'fk_insumo_pedido_pedido1_idx')
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
