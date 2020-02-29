<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipomuestrasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tipomuestras';

    /**
     * Run the migrations.
     * @table tipomuestras
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('tipo_muestra', 45);
            $table->unsignedInteger('matriz_id');

            $table->index(["matriz_id"], 'fk_tipomuestra_matriz1_idx');


            $table->foreign('matriz_id', 'fk_tipomuestra_matriz1_idx')
                ->references('id')->on('matrizs')
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
