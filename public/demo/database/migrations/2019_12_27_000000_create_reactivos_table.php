<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReactivosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'reactivos';

    /**
     * Run the migrations.
     * @table reactivos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('codigo', 45)->nullable()->default(null);
            $table->string('nombre')->nullable()->default(null);
            $table->string('descripcion')->nullable()->default(null);
            $table->string('numero_cas', 45)->nullable()->default(null);
            $table->string('ensayo')->nullable()->default(null);
            $table->string('area', 45)->nullable()->default(null);
            $table->tinyInteger('renpre')->nullable()->default(null);
            $table->integer('costo')->nullable();
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
