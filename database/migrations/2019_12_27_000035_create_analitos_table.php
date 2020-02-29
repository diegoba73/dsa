<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalitosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'analitos';

    /**
     * Run the migrations.
     * @table analitos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('analito')->nullable()->default(null);
            $table->string('valor_hallado')->nullable()->default(null);
            $table->string('unidad')->nullable()->default(null);
            $table->string('observaciones')->nullable()->default(null);
            $table->string('parametro_calidad')->nullable()->default(null);
            $table->unsignedInteger('muestra_id');

            $table->index(["muestra_id"], 'fk_analito_muestra1_idx');


            $table->foreign('muestra_id', 'fk_analito_muestra1_idx')
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
