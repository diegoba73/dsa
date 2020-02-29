<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemitentesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'remitentes';

    /**
     * Run the migrations.
     * @table remitentes
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre')->nullable()->default(null);
            $table->string('contacto')->nullable()->default(null);
            $table->string('area')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('direccion')->nullable()->default(null);
            $table->string('telefono', 45)->nullable()->default(null);
            $table->string('otro')->nullable();
            $table->unsignedInteger('localidad_id');

            $table->index(["localidad_id"], 'fk_remitente_localidad1_idx');


            $table->foreign('localidad_id', 'fk_remitente_localidad1_idx')
                ->references('id')->on('localidads')
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
