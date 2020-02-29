<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicroorganismosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'microorganismos';

    /**
     * Run the migrations.
     * @table microorganismos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('numero', 45);
            $table->string('microorganismo', 45);
            $table->string('medio_cultivo', 45)->nullable()->default(null);
            $table->string('condiciones', 45)->nullable()->default(null);
            $table->string('tsi', 45)->nullable()->default(null);
            $table->string('citrato', 45)->nullable()->default(null);
            $table->string('lia', 45)->nullable()->default(null);
            $table->string('urea', 45)->nullable()->default(null);
            $table->string('sim', 45)->nullable()->default(null);
            $table->string('esculina', 45)->nullable()->default(null);
            $table->string('hemolisis', 45)->nullable()->default(null);
            $table->string('tumbling', 45)->nullable()->default(null);
            $table->string('fluorescencia', 45)->nullable()->default(null);
            $table->string('coagulasa', 45)->nullable()->default(null);
            $table->string('oxidasa', 45)->nullable()->default(null);
            $table->string('catalasa', 45)->nullable()->default(null);
            $table->string('gram', 45)->nullable()->default(null);
            $table->string('observaciones', 45)->nullable()->default(null);
            $table->unsignedInteger('proveedor_id');

            $table->index(["proveedor_id"], 'fk_microorganismo_proveedor1_idx');


            $table->foreign('proveedor_id', 'fk_microorganismo_proveedor1_idx')
                ->references('id')->on('proveedors')
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
