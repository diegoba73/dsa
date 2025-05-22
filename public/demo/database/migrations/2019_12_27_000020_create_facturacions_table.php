<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturacionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'facturacions';

    /**
     * Run the migrations.
     * @table facturacions
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('depositante', 45)->nullable();
            $table->string('detalle', 45)->nullable()->default(null);
            $table->string('importe', 45);
            $table->string('codigo_pago')->nullable()->default(null);
            $table->date('fecha_pago')->nullable()->default(null);
            $table->string('codigo_barra', 50)->nullable()->default(null);
            $table->unsignedInteger('user_id');

            $table->index(["user_id"], 'fk_facturacion_user1_idx');


            $table->foreign('user_id', 'fk_facturacion_user1_idx')
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
