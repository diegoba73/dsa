<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsonotasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'dsonotas';

    /**
     * Run the migrations.
     * @table dsonotas
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('numero')->nullable()->default(null);
            $table->date('fecha')->nullable()->default(null);
            $table->string('descripcion')->nullable()->default(null);
            $table->unsignedInteger('user_id');

            $table->index(["user_id"], 'fk_dsonota_user1_idx');


            $table->foreign('user_id', 'fk_dsonota_user1_idx')
                ->references('id')->on('users')
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
