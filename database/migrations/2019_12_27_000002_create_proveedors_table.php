<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'proveedors';

    /**
     * Run the migrations.
     * @table proveedors
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('empresa', 45);
            $table->string('contacto', 45)->nullable()->default(null);
            $table->string('direccion', 45)->nullable()->default(null);
            $table->string('telefono', 45)->nullable()->default(null);
            $table->string('email', 45)->nullable()->default(null);
            $table->string('tipo_insumo', 45)->nullable()->default(null);
            $table->string('criticidad', 45)->nullable()->default(null);
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
