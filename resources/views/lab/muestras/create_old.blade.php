@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.muestras.create', 'title' => __('Sistema DPSA')])
@section('content')
{{ Form::hidden('url', URL::full()) }}
<div class="container bg-primary" style="height: auto;">
  <div class="row justify-content-center">
  
                <div class="card-body">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

            <div class="content bg-primary">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col-md-16">
                            <div class="card">
                                <div class="alert alert-default">
                                    <strong class="card-title">Ingreso de Muestra</strong>
                                </div>
                                <div class="card-body">
                                    <form name="form_check" id="form_check" class="form-prevent-multiple-submit" method="post" action="{{ url('/lab/muestras/') }}"> 
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Cantidad de ingresos:</label>
                                                    <input type="text" class="form-control form-control-sm" name="ingresos" value="1">
                                                </div>
                                            </div>
                                            @if (Auth::user()->id == 6 || Auth::user()->id == 30 || Auth::user()->id == 2885)
                                            <div class="col-6">
                                                <div class="form-group">
                                                <label for="departamento_id">Departamento:</label>
                                                            <p>
                                                            {!!Form::select('departamento_id',array('1' => 'DL', '2' => 'DB', '3' => 'DSB','4' => 'DSO'), '4', ['class' => 'chosen-select', 'style' => 'width: 70px;'])!!}
                                                            </p>
                                                </div>
                                            </div>
                                            @else
                                            <input type="hidden" value="{{ Auth::user()->departamento_id }}" name="departamento_id">
                                            @endif
                                        </div>
                                        <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="solicitante">Solicitante:</label><br>
                                                <select class="chosen-select" name="solicitante" @if($remitente) disabled @endif>
                                                    <option disabled selected>Seleccionar Solicitante</option>
                                                    @foreach($remitentes as $remitenteOption)
                                                        <option value="{{$remitenteOption->nombre}}" @if($remitente && $remitente->nombre === $remitenteOption->nombre) selected @endif>{{$remitenteOption->nombre}}</option>
                                                    @endforeach
                                                </select>
                                                <small class="form-text text-danger">* El Solicitante es requerido.</small>
                                                <input type="hidden" name="solicitante_hidden" value="{{ $remitente ? $remitente->nombre : '' }}">
                                            </div>
                                        </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="entrada">Entrada:</label>
                                                            <p>
                                                            {!! Form::select(
                                                                'entrada', 
                                                                ['Seleccionar Entrada', 'DECOMISO' => 'DECOMISO', 'CONTROL' => 'CONTROL', 'INTERVENCION' => 'INTERVENCION', 'DENUNCIA' => 'DENUNCIA', 'LICITACION' => 'LICITACION', 'INTOXICACION' => 'INTOXICACION', 'MUESTREO PROGRAMADO' => 'MUESTREO PROGRAMADO'],
                                                                (auth()->user()->role_id === 13) ? 'CONTROL' : null,
                                                                ['class' => 'chosen-select', 'disabled' => (auth()->user()->role_id === 13)]
                                                            ) !!}
                                                            <small class="form-text text-danger">* El Tipo de Entrada es requerida.</small>
                                                            </p>
                                                            <input type="hidden" name="entrada_hidden" value="CONTROL">
                                                </div> 
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="remitente">Remitente:</label><br>
                                                        <select class="chosen-select" name="remitente" @if($remitente) disabled @endif>
                                                            <option disabled selected>Seleccionar Remitente</option>
                                                            @foreach($remitentes as $remitenteOption)
                                                                <option value="{{$remitenteOption->id}}" @if($remitente && $remitente->id === $remitenteOption->id) selected @endif>{{$remitenteOption->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    <small class="form-text text-danger">* El Remitente es requerido.</small>
                                                    <input type="hidden" name="remitente_hidden" value="{{ $remitente ? $remitente->id : '' }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="tipo_prestacion">Tipo de Prestación:</label>
                                                            <p>
                                                            {!! Form::select(
                                                                'tipo_prestacion', 
                                                                ['Seleccionar Prestación', 'APS' => 'APS', 'CONVENIO' => 'CONVENIO', 'ARANCELADO' => 'ARANCELADO', 'CALIDAD' => 'CALIDAD', 'CONTROL INTERNO' => 'CONTROL INTERNO'],
                                                                (auth()->user()->role_id === 13) ? 'ARANCELADO' : null,
                                                                ['class' => 'chosen-select', 'disabled' => (auth()->user()->role_id === 13)]
                                                            ) !!}
                                                            <small class="form-text text-danger">* El Tipo de Prestación es requerido.</small>
                                                            </p>
                                                            <input type="hidden" name="tipo_prestacion_hidden" value="ARANCELADO">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                            <div class="form-group">
                                            <label for="matriz">Matriz:</label><br>
                                                        <select class="chosen-select" name="matriz_id" id="matriz">
                                                            <option disabled selected>Seleccionar Matriz</option>
                                                            @foreach($matrizs as $matriz)
                                                            <option value="{{$matriz->id}}">{{$matriz->matriz}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* La matriz es requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="tipomuestra">Tipo de Muestra:</label><br>
                                                        <select name="tipomuestra_id" id="tipomuestra"></select>
                                                        <small class="form-text text-danger">* El Tipo de Muestra es requerida.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Muestra:</label>
                                                    <input type="text" class="form-control form-control-sm" name="muestra">
                                                    <small class="form-text text-danger">* La descripción de la Muestra es requerida.</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nº Cert. Cadena de Custodia:</label>
                                                    <input type="text" class="form-control form-control-sm" name="cadena custodia">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Identificación:</label>
                                                    <input type="text" class="form-control form-control-sm" name="identificacion">
                                                </div>
                                            </div>                                        
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de Entrada:</label>
                                                    <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_entrada" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Realizó Muestreo:</label>
                                                    <input type="text" class="form-control form-control-sm datetimepicker" name="realizo_muestreo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="provincia">Provincia:</label><br>
                                                    <select class="chosen-select" name="provincia_id" id="provincia">
                                                        <option disabled selected>Seleccionar Provincia</option>
                                                        @foreach($provincias as $provincia)
                                                        <option value="{{$provincia->id}}">{{$provincia->provincia}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-danger">* La provincia es requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="localidad">Localidad:</label><br>
                                                        <select name="localidad_id" id="localidad"></select>
                                                        <small class="form-text text-danger">* La Localidad es requerida.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Lugar de Extracción:</label>
                                                    <input type="text" class="form-control form-control-sm" name="lugar_extraccion">
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                        <div class="col">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de Extracción:</label>
                                                    <input type="date" class="form-control form-control-sm" name="fecha_extraccion">
                                                    <small class="form-text text-danger">* La Fecha es requerida.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Hora Extración:</label>
                                                    <input type="text" class="form-control form-control-sm" name="hora_extraccion">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Conservación:</label>
                                                    <input type="text" class="form-control form-control-sm" name="conservacion">
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Cloro:</label>
                                                    <input type="text" class="form-control form-control-sm" name="cloro_residual">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Tipo de Envase:</label>
                                                    <input type="text" class="form-control form-control-sm" name="tipo_envase">
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Cantidad:</label>
                                                    <input type="text" class="form-control form-control-sm" name="cantidad">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Peso/Volúmen:</label>
                                                    <input type="text" class="form-control form-control-sm" name="peso_volumen"> 
                                                </div>
                                            </div>
                                            @if (Auth::user()->departamento_id == 3 || Auth::user()->departamento_id == 4)
                                            <tr></tr>
                                            @else
                                            </div>
                                            <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Fecha de Elaborado:</label>
                                                    <input type="text" class="form-control form-control-sm" name="fecha_elaborado">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Fecha de Vencimiento:</label>
                                                    <input type="text" class="form-control form-control-sm" name="fecha_vencimiento">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Elaborado por:</label>
                                                    <input type="text" class="form-control form-control-sm" name="elaborado">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Marca:</label>
                                                    <input type="text" class="form-control form-control-sm" name="marca">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Domicilio</label>
                                                    <input type="text" class="form-control form-control-sm" name="domicilio">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                                        
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Reg. de Establecimiento:</label>
                                                    <input type="text" class="form-control form-control-sm" name="registro_est">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Reg. de Producto:</label>
                                                    <input type="text" class="form-control form-control-sm" name="registro_prod">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Lote:</label>
                                                    <input type="text" class="form-control form-control-sm" name="lote">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Partida:</label>
                                                    <input type="text" class="form-control form-control-sm" name="partida">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Destino:</label>
                                                    <input type="text" class="form-control form-control-sm" name="destino">
                                                </div>
                                            </div>
                                            @endif
                                        </div>
<!--                                         <div class="border border-danger rounded">
                                            <br>
                                            <div class="row"> 
                                                <div class="col">
                                                    <div class="form-group ml-4">
                                                        <input name="microbiologia" id="microbiologia" type="checkbox" value="1">   
                                                        <label class="bmd-label-floating">Microbiología:</label>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <input name="quimica" id="quimica" type="checkbox" value="1">   
                                                        <label class="bmd-label-floating">Química:</label>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <input name="cromatografia" id="cromatografia" type="checkbox" value="1">   
                                                        <label class="bmd-label-floating">Cromatografía:</label>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <input name="ensayo_biologico" id="ensayo_biologico" type="checkbox" value="1">  
                                                        <label class="bmd-label-floating">Ensayo Biológico:</label>
                                                    
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="row"> 
                                                <small class="form-text text-danger ml-4">* El campo de Área analítica al menos debe tener 1 seleccionado.</small>
                                            </div>
                                        <br>
                                        </div> -->
                                        <br>
                                        @if (Auth::user()->departamento_id == 1)
                                        <div class="row">                                                                                                                                 
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Aceptada:</label>
                                                    {!! Form::checkbox('aceptada', true, NULL) !!}
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        @endif
                                        <div class="border border-danger rounded">
                                        <div class="row">
                                            <div class="col-md-16">
                                            <br>
                                                <div class="form-group ml-4">
                                                {!! Form::Label('ensayos_id', 'Ensayos:') !!}
                                                
                                                <select name="ensayo_id[]" id="ensayos" multiple="multiple" style="width: 950px">
                                                
                                                </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                            <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit" name="submit">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                Ingresar
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
<script>
    // Obtener el campo de entrada de fecha
    var inputFecha = document.getElementById('datepicker');

    // Obtener la fecha actual
    var fechaActual = new Date().toISOString().split('T')[0];

    // Establecer la fecha máxima como la fecha actual para restringir fechas futuras
    inputFecha.max = fechaActual;

    // Escuchar cambios en el campo de fecha para evitar que ingresen fechas futuras
    inputFecha.addEventListener('input', function(event) {
        if (event.target.value > fechaActual) {
            event.target.value = fechaActual;
        }
    });
</script>
