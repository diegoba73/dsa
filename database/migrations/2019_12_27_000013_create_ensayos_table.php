<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnsayosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'ensayos';

    /**
     * Run the migrations.
     * @table ensayos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('codigo', 11)->nullable()->default(null);
            $table->string('tipo_ensayo', 45)->nullable()->default(null);
            $table->string('ensayo')->nullable()->default(null);
            $table->string('metodo')->nullable()->default(null);
            $table->string('norma_procedimiento', 100)->nullable();
            $table->unsignedInteger('matriz_id');
            $table->string('unidades')->nullable()->default(null);
            $table->string('valor_referencia')->nullable()->default('0');
            $table->string('limite_d', 45)->nullable();
            $table->string('limite_c', 45)->nullable();
            $table->integer('costo')->nullable()->default(null);
            $table->tinyInteger('activo')->nullable();

            $table->index(["matriz_id"], 'fk_ensayo_matriz1_idx');


            $table->foreign('matriz_id', 'fk_ensayo_matriz1_idx')
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
