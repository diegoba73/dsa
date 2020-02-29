<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMuestrasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'muestras';

    /**
     * Run the migrations.
     * @table muestras
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('departamento_id');
            $table->unsignedInteger('numero');
            $table->string('tipo_prestacion', 45);
            $table->string('entrada', 45);
            $table->string('nro_cert_cadena_custodia', 45)->nullable()->default(null);
            $table->unsignedInteger('matriz_id');
            $table->unsignedInteger('tipomuestra_id');
            $table->string('muestra');
            $table->string('identificacion')->nullable()->default(null);
            $table->string('solicitante', 45);
            $table->unsignedInteger('remitente_id');
            $table->date('fecha_entrada')->nullable()->default(null);
            $table->string('realizo_muestreo')->nullable()->default(null);
            $table->string('lugar_extraccion')->nullable()->default(null);
            $table->date('fecha_extraccion')->nullable()->default(null);
            $table->string('hora_extraccion', 50)->nullable()->default(null);
            $table->unsignedInteger('provincia_id');
            $table->unsignedInteger('localidad_id');
            $table->string('conservacion')->nullable();
            $table->string('cloro_residual')->nullable()->default(null);
            $table->string('elaborado_por')->nullable()->default(null);
            $table->string('domicilio')->nullable()->default(null);
            $table->string('marca')->nullable()->default(null);
            $table->string('tipo_envase')->nullable()->default(null);
            $table->string('cantidad')->nullable()->default(null);
            $table->string('peso_volumen')->nullable()->default(null);
            $table->string('fecha_elaborado')->nullable()->default(null);
            $table->string('fecha_vencimiento')->nullable()->default(null);
            $table->string('registro_establecimiento')->nullable()->default(null);
            $table->string('registro_producto')->nullable()->default(null);
            $table->string('lote')->nullable()->default(null);
            $table->string('partida')->nullable()->default(null);
            $table->string('destino')->nullable()->default(null);
            $table->tinyInteger('microbiologia')->nullable();
            $table->tinyInteger('quimica')->nullable();
            $table->tinyInteger('cromatografia')->nullable();
            $table->tinyInteger('ensayo_biologico')->nullable();
            $table->tinyInteger('aceptada')->nullable()->default(null);
            $table->string('criterio_rechazo')->nullable()->default(null);
            $table->date('fecha_recepcion_analista')->nullable()->default(null);
            $table->date('fecha_inicio_analisis')->nullable()->default(null);
            $table->date('fecha_fin_analisis')->nullable()->default(null);
            $table->string('observaciones')->nullable()->default(null);
            $table->string('condicion', 45)->default('Sin/Conclusion');
            $table->tinyInteger('cargada')->nullable()->default(null);
            $table->string('reviso', 50)->nullable()->default(null);
            $table->date('fecha_salida')->nullable()->default(null);
            $table->tinyInteger('remitir')->nullable()->default(null);
            $table->string('codigo_barra', 50)->nullable()->default(null);
            $table->unsignedInteger('user_id');

            $table->index(["remitente_id"], 'fk_muestra_remitente1_idx');

            $table->index(["user_id"], 'fk_muestra_user1_idx');

            $table->index(["localidad_id"], 'fk_muestra_localidad1_idx');

            $table->index(["provincia_id"], 'fk_muestra_provincia1_idx');

            $table->index(["departamento_id"], 'fk_muestra_departamento1_idx');

            $table->index(["matriz_id"], 'fk_muestra_matriz1_idx');

            $table->index(["tipomuestra_id"], 'fk_muestra_tipomuestra1_idx');
            $table->nullableTimestamps();


            $table->foreign('departamento_id', 'fk_muestra_departamento1_idx')
                ->references('id')->on('departamentos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('remitente_id', 'fk_muestra_remitente1_idx')
                ->references('id')->on('remitentes')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('localidad_id', 'fk_muestra_localidad1_idx')
                ->references('id')->on('localidads')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_muestra_user1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('provincia_id', 'fk_muestra_provincia1_idx')
                ->references('id')->on('provincias')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipomuestra_id', 'fk_muestra_tipomuestra1_idx')
                ->references('id')->on('tipomuestras')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('matriz_id', 'fk_muestra_matriz1_idx')
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
