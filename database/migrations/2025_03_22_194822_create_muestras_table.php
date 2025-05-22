<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMuestrasTable extends Migration
{
    public function up()
    {
        Schema::create('muestras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id')->nullable(false);
            $table->integer('departamento_id')->nullable(false);
            $table->integer('numero')->nullable(false);
            $table->string('tipo_prestacion')->nullable(false);
            $table->string('entrada')->nullable(false);
            $table->string('nro_cert_cadena_custodia')->nullable()->default('NULL');
            $table->integer('matriz_id')->nullable(false);
            $table->integer('tipomuestra_id')->nullable(false);
            $table->string('muestra')->nullable(false);
            $table->string('identificacion')->nullable()->default('NULL');
            $table->string('solicitante')->nullable(false);
            $table->integer('remitente_id')->nullable(false);
            $table->date('fecha_entrada')->nullable()->default('NULL');
            $table->string('realizo_muestreo')->nullable()->default('NULL');
            $table->string('lugar_extraccion')->nullable()->default('NULL');
            $table->date('fecha_extraccion')->nullable()->default('NULL');
            $table->string('hora_extraccion')->nullable()->default('NULL');
            $table->integer('provincia_id')->nullable(false);
            $table->integer('localidad_id')->nullable(false);
            $table->string('conservacion')->nullable()->default('NULL');
            $table->string('cloro_residual')->nullable()->default('NULL');
            $table->string('elaborado_por')->nullable()->default('NULL');
            $table->string('domicilio')->nullable()->default('NULL');
            $table->string('marca')->nullable()->default('NULL');
            $table->string('tipo_envase')->nullable()->default('NULL');
            $table->string('cantidad')->nullable()->default('NULL');
            $table->string('peso_volumen')->nullable()->default('NULL');
            $table->string('fecha_elaborado')->nullable()->default('NULL');
            $table->string('fecha_vencimiento')->nullable()->default('NULL');
            $table->string('registro_establecimiento')->nullable()->default('NULL');
            $table->string('registro_producto')->nullable()->default('NULL');
            $table->string('lote')->nullable()->default('NULL');
            $table->string('partida')->nullable()->default('NULL');
            $table->string('destino')->nullable()->default('NULL');
            $table->integer('microbiologia')->nullable()->default('NULL');
            $table->integer('quimica')->nullable()->default('NULL');
            $table->integer('cromatografia')->nullable()->default('NULL');
            $table->integer('ensayo_biologico')->nullable()->default('NULL');
            $table->integer('aceptada')->nullable()->default('NULL');
            $table->string('criterio_rechazo')->nullable()->default('NULL');
            $table->date('fecha_recepcion_analista')->nullable()->default('NULL');
            $table->date('fecha_inicio_analisis')->nullable()->default('NULL');
            $table->date('fecha_fin_analisis')->nullable()->default('NULL');
            $table->string('observaciones')->nullable()->default('NULL');
            $table->string('condicion')->nullable(false)->default('Sin/Conclusion');
            $table->integer('cargada')->nullable()->default('NULL');
            $table->string('reviso')->nullable()->default('NULL');
            $table->integer('revisada')->nullable()->default('NULL');
            $table->integer('traducida')->nullable()->default('NULL');
            $table->date('fecha_salida')->nullable()->default('NULL');
            $table->integer('remitir')->nullable()->default('NULL');
            $table->string('codigo_barra')->nullable()->default('NULL');
            $table->integer('user_id')->nullable(false);
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->integer('factura_id')->nullable()->default('NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('muestras');
    }
}
