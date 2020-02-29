<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'pedidos';

    /**
     * Run the migrations.
     * @table pedidos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('nro_pedido');
            $table->date('fecha_pedido')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('pasado_a', 45)->nullable();
            $table->date('fecha_pase')->nullable();
            $table->string('nro_nota', 45)->nullable();
            $table->string('nro_expediente', 45)->nullable();
            $table->tinyInteger('finalizado')->nullable();
            $table->tinyInteger('rechazado')->nullable();
            $table->string('observaciones', 45)->nullable();
            $table->string('costo_total', 10)->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('departamento_id');

            $table->index(["departamento_id"], 'fk_pedido_departamento1_idx');

            $table->index(["user_id"], 'fk_pedido_user1_idx');


            $table->foreign('user_id', 'fk_pedido_user1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('departamento_id', 'fk_pedido_departamento1_idx')
                ->references('id')->on('departamentos')
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
