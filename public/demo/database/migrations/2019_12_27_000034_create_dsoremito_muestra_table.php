<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsoremitoMuestraTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'dsoremito_muestra';

    /**
     * Run the migrations.
     * @table dsoremito_muestra
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('dsoremito_id');
            $table->unsignedInteger('muestra_id');

            $table->index(["muestra_id"], 'fk_dsoremito_muestra_muestra1_idx');

            $table->index(["dsoremito_id"], 'fk_dsoremito_muestra_dsoremito1_idx');


            $table->foreign('dsoremito_id', 'fk_dsoremito_muestra_dsoremito1_idx')
                ->references('id')->on('dsoremitos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('muestra_id', 'fk_dsoremito_muestra_muestra1_idx')
                ->references('id')->on('muestras')
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
