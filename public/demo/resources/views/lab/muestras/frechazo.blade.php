@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.muestras.create', 'title' => __('Sistema DPSA')])
@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
                <div class="card-body">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        
                    <div class="col-md-16">
                            <div class="card">
                                <div class="alert alert-default">
                                <strong class="card-title">Formulario de Rechazo Muestra Nº {{$muestra->numero}}</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-prevent-multiple-submit" method="post" action="{{ url('/lab/muestras/'.$muestra->id.'/frechazo') }}">
                                        {{ csrf_field() }}
                                        <input name="url" type="hidden" value="{{ $url }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                        <label for="solicitante">Solicitante:</label>
                                                            <p>{{ $muestra->solicitante}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                        <label for="entrada">Entrada:</label>
                                                            <p>
                                                            {{ $muestra->entrada}}
                                                            </p>
                                                </div> 
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                        <label for="tipo_prestacion">Tipo de Prestación:</label>
                                                            <p>
                                                            {{ $muestra->tipo_prestacion}}
                                                            </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label for="solicitante">Remite:</label>
                                                <p>{{ $muestra->remitente->nombre}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="matriz">Matriz:</label>
                                                    <p>
                                                    {{ $muestra->matriz->matriz}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                        <label for="tipo_muestra">Tipo de Muestra:</label>
                                                            <p>
                                                            {{ $muestra->tipo_muestra}}
                                                            </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Muestra:</label>
                                                    <p>{{ $muestra->muestra}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nº Cert. Cadena de Custodia:</label>
                                                    <p>{{ $muestra->nro_cert_cadena_custodia}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                        </div>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Identificación:</label>
                                                    <p>{{ $muestra->identificacion}}</p>
                                                </div>
                                            </div>                                        
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de Entrada:</label>
                                                    <p>{{ date('d-m-Y', strtotime($muestra->fecha_entrada)) }}</p>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Realizó Muestreo:</label>
                                                    <p>{{ $muestra->realizo_muestreo}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                        <label for="localidad">Localidad:</label>
                                                        <p>{{ $muestra->localidad->localidad}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="matriz">Provincia:</label>
                                                <p>{{ $muestra->provincia->provincia}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Lugar de Extracción:</label>
                                                    <p>{{ $muestra->lugar_extraccion}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de Extracción:</label>
                                                    <p>{{ date('d-m-Y', strtotime($muestra->fecha_extraccion)) }}</p>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Conservación:</label>
                                                    <p>{{ $muestra->conservacion}}</p>
                                                </div>
                                            </div>
                                            @if ($muestra->matriz == "Agua")
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Cloro:</label>
                                                    <p>{{ $muestra->cloro_residual}}</p>
                                                </div>
                                            </div>
                                            @else
                                            <i></i>
                                            @endif
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Tipo de Envase:</label>
                                                    <p>{{ $muestra->tipo_envase}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Cantidad:</label>
                                                    <p>{{ $muestra->cantidad}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Peso/Volúmen:</label>
                                                    <p>{{ $muestra->peso_volumen}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de Elaborado:</label>
                                                    <p>{{ $muestra->fecha_elaborado}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Fecha de Vencimiento:</label>
                                                    <p>{{ $muestra->fecha_vencimiento}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Elaborado por:</label>
                                                    <p>{{ $muestra->elaborado_por}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Domicilio</label>
                                                    <p>{{ $muestra->domicilio}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Marca:</label>
                                                    <p>{{ $muestra->marca}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                                        
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Registro de Establecimiento:</label>
                                                    <p>{{ $muestra->registro_establecimiento}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Registro de Producto:</label>
                                                    <p>{{ $muestra->registro_producto}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Lote:</label>
                                                    <p>{{ $muestra->lote}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Partida:</label>
                                                    <p>{{ $muestra->partida}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Destino:</label>
                                                    <p>{{ $muestra->destino}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">   
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Condición:</label>
                                                    <p>{{ $muestra->condicion}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">   
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Criterio de Rechazo:</label>
                                                    <input type="text" class="form-control form-control-sm" name="criterio_rechazo" value="{{ $muestra->criterio_rechazo}}">
                                                    <small class="form-text text-danger">* Colocar el criterio por el cual se rechaza la muestra.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ route('lab_muestras_index') }}">Cancelar</a>
                                            <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                Rechazar
                                            </button>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>   
@endsection