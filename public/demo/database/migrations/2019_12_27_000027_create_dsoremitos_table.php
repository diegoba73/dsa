<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsoremitosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'dsoremitos';

    /**
     * Run the migrations.
     * @table dsoremitos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('fecha');
            $table->text('conclusion')->nullable();
            $table->integer('nro_nota')->nullable();
            $table->unsignedInteger('remitente_id');
            $table->unsignedInteger('user_id');

            $table->index(["remitente_id"], 'fk_dsoremito_remitente1_idx');

            $table->index(["user_id"], 'fk_dsoremito_user1_idx');


            $table->foreign('remitente_id', 'fk_dsoremito_remitente1_idx')
                ->references('id')->on('remitentes')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_dsoremito_user1_idx')
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
