<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalidadsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'localidads';

    /**
     * Run the migrations.
     * @table localidads
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('codigo_postal', 45)->nullable()->default(null);
            $table->string('localidad')->nullable()->default(null);
            $table->unsignedInteger('provincia_id');

            $table->index(["provincia_id"], 'fk_localidad_provincia1_idx');


            $table->foreign('provincia_id', 'fk_localidad_provincia1_idx')
                ->references('id')->on('provincias')
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
