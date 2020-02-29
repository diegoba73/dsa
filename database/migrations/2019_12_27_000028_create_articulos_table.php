<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'articulos';

    /**
     * Run the migrations.
     * @table articulos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('item')->nullable();
            $table->string('cantidad', 5)->nullable();
            $table->string('precio', 10)->nullable();
            $table->unsignedInteger('pedido_id');

            $table->index(["pedido_id"], 'fk_articulo_pedido1_idx');


            $table->foreign('pedido_id', 'fk_articulo_pedido1_idx')
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
