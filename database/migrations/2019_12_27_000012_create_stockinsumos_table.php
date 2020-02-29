<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockinsumosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'stockinsumos';

    /**
     * Run the migrations.
     * @table stockinsumos
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
            $table->date('fecha_baja')->nullable();
            $table->string('cantidad', 45)->nullable();
            $table->string('marca', 45)->nullable();
            $table->string('almacenamiento', 45)->nullable();
            $table->string('certificado', 45)->nullable();
            $table->string('observaciones')->nullable();
            $table->string('codigo_barra', 50)->nullable();
            $table->string('pedido', 10)->nullable();
            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('insumo_id');

            $table->index(["proveedor_id"], 'fk_stockinsumo_proveedor1_idx');

            $table->index(["insumo_id"], 'fk_stockinsumo_insumo1_idx');


            $table->foreign('proveedor_id', 'fk_stockinsumo_proveedor1_idx')
                ->references('id')->on('proveedors')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('insumo_id', 'fk_stockinsumo_insumo1_idx')
                ->references('id')->on('insumos')
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
