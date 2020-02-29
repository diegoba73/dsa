<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCepasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'cepas';

    /**
     * Run the migrations.
     * @table cepas
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('microorganismo_id');
            $table->string('lote', 45);
            $table->date('fecha_incubacion');
            $table->string('tsi', 45)->nullable()->default(null);
            $table->string('citrato', 45)->nullable()->default(null);
            $table->string('lia', 45)->nullable()->default(null);
            $table->string('urea', 45)->nullable()->default(null);
            $table->string('sim', 45)->nullable()->default(null);
            $table->string('esculina', 45)->nullable()->default(null);
            $table->string('hemolisis', 45)->nullable()->default(null);
            $table->string('tumbling', 45)->nullable()->default(null);
            $table->string('fluorescencia', 45)->nullable()->default(null);
            $table->string('coagulasa', 45)->nullable()->default(null);
            $table->string('oxidasa', 45)->nullable()->default(null);
            $table->string('catalasa', 45)->nullable()->default(null);
            $table->string('gram', 45)->nullable()->default(null);
            $table->string('observaciones', 45)->nullable()->default(null);
            $table->string('codigo_barra', 50)->nullable()->default(null);
            $table->unsignedInteger('user_id');

            $table->index(["microorganismo_id"], 'fk_cepa_microorganismo1_idx');

            $table->index(["user_id"], 'fk_cepa_user1_idx');
            $table->nullableTimestamps();


            $table->foreign('microorganismo_id', 'fk_cepa_microorganismo1_idx')
                ->references('id')->on('microorganismos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_cepa_user1_idx')
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
