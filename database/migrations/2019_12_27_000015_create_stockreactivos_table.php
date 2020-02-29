<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockreactivosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'stockreactivos';

    /**
     * Run the migrations.
     * @table stockreactivos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('registro', 45)->nullable();
            $table->date('fecha_entrada')->nullable();
            $table->date('fecha_apertura')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_baja')->nullable();
            $table->string('contenido', 45)->nullable();
            $table->string('marca', 45)->nullable();
            $table->string('grado', 45)->nullable();
            $table->string('lote', 45)->nullable();
            $table->string('conservacion', 45)->nullable();
            $table->string('almacenamiento', 45)->nullable();
            $table->tinyInteger('hs')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('codigo_barra', 45)->nullable();
            $table->string('pedido', 10)->nullable();
            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('reactivo_id');

            $table->index(["proveedor_id"], 'fk_stockreactivo_proveedor1_idx');

            $table->index(["reactivo_id"], 'fk_stockreactivo_reactivo1_idx');


            $table->foreign('proveedor_id', 'fk_stockreactivo_proveedor1_idx')
                ->references('id')->on('proveedors')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('reactivo_id', 'fk_stockreactivo_reactivo1_idx')
                ->references('id')->on('reactivos')
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
