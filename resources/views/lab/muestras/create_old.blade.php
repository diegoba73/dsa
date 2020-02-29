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
                                    <form class="form-prevent-multiple-submit" method="post" action="{{ url('/lab/muestras/') }}"> 
                                        {{ csrf_field() }}
                                        <div class="row">
                                        @if (Auth::user()->departamento_id == 1)
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Cantidad de ingresos:</label>
                                                    <input type="text" class="form-control form-control-sm" name="ingresos" value="1">
                                                </div>
                                            </div>
                                        @else
                                        <div class="col-md-2" style="display: none;">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Cantidad de ingresos:</label>
                                                    <input type="text" class="form-control form-control-sm" name="ingresos" value="1">
                                                </div>
                                            </div>
                                        @endif
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="localidad">Solicitante:</label><br>
                                                        <select class="chosen-select" name="solicitante">
                                                            <option disabled selected>Seleccionar Solicitante</option>
                                                            @foreach($solicitantes as $solicitante)
                                                            <option value="{{$solicitante->id}}">{{$solicitante->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* El Solicitante es requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="entrada">Entrada:</label>
                                                            <p>
                                                            {!!Form::select('entrada',[null=>'Seleccionar Entrada'] + array('Decomiso' => 'Decomiso','Control' => 'Control','Intervención' => 'Intervención','Particular' => 'Particular','Inscripción' => 'Inscripción','Secuestro Preventivo' => 'Secuestro Preventivo','Denuncia' => 'Denuncia','Donación' => 'Donación','Licitación' => 'Licitación','Intoxicación' => 'Intoxicación','Triquinosis' => 'Triquinosis','Muestreo Programado' => 'Muestreo Programado','Marea Roja' => 'Marea Roja'), null, ['class' => 'chosen-select'])!!}
                                                            <small class="form-text text-danger">* El Tipo de Entrada es requerida.</small>
                                                            </p>
                                                </div> 
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="tipo_prestacion">Tipo de Prestación:</label>
                                                            <p>
                                                            {!!Form::select('tipo_prestacion',[null=>'Seleccionar Tipo de Prestación'] +  array('APS' => 'APS','Convenio' => 'Convenio','Arancelado' => 'Arancelado','Calidad' => 'Calidad', 'Control Interno' => 'Control Interno'), null, ['class' => 'chosen-select'])!!}
                                                            <small class="form-text text-danger">* El Tipo de Prestación es requerido.</small>
                                                            </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="remitente">Remitente:</label><br>
                                                        <select class="chosen-select" name="remitente">
                                                            <option disabled selected>Seleccionar Remitente</option>
                                                            @foreach($remitentes as $remitente)
                                                            <option value="{{$remitente->id}}">{{$remitente->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* El Remitente es requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                            <div class="form-group">
                                            <label for="matriz">Matriz:</label><br>
                                                        <select class="chosen-select" name="matriz" id="matriz">
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
                                                        <label for="tipo_muestra">Tipo de Muestra:</label>
                                                            <p>
                                                            {!!Form::select('tipo_muestra',[null=>'Seleccionar Tipo de Muestra'] +  array(
                                                                'Alimentos' => array('Alimento Carneo y Afin' => 'Alimento Carneo y Afin','Alimento Graso' => 'Alimento Graso','Alimento Lacteo' => 'Alimento Lacteo','Alimento Farinaceo' => 'Alimento Farinaceo','Alimento Azucarado' => 'Alimento Azucarado','Alimento Vegetal' => 'Alimento Vegetal','Bebida Hidrica' => 'Bebida Hidrica','Bebida Fermentada' => 'Bebida Fermentada','Bebida Espirituosa' => 'Bebida Espirituosa','Producto Estimulante' => 'Producto Estimulante','Correctivo y Coadjubante' => 'Correctivo y Coadjubante','Alimento de Regimen','Aditivo Alimentario' => 'Aditivo Alimentario'),
                                                                'Aguas' => array('Agua de Red' => 'Agua de Red','Hielo' => 'Hielo','Agua Tratada' => 'Agua Tratada', 'Agua Superficial' => 'Agua Superficial','Agua Subterranea' => 'Agua Subterranea'),
                                                                'Efluentes' => array('Efluente Tratado' => 'Efluente Tratado','Efluente Sin Tratar' => 'Efluente Sin Tratar'),
                                                                'Ambientales' => array('Hisopo' => 'Hisopo','Gasa' => 'Gasa','Placas' => 'Placas','Control Ambiental' => 'Control Ambiental'),
                                                                'Plancton' => array('Fitoplancton' => 'Fitoplancton','Zooplancton' => 'Zooplancton'),
                                                                'Otro' => array('Tejido Orgánico' => 'Tejido Orgánico','Cebo' => 'Cebo','Líquido' => 'Líquido','Extracto vegetal' => 'Extracto vegetal','Polvo Sedimentable' => 'Polvo Sedimentable','Domisanitario' => 'Domisanitario','Productos Desinfectantes' => 'Productos Desinfectantes','Natural' => 'Natural','Preparado' => 'Preparado','Sangre' => 'Sangre','Contenido Estomacal' => 'Contenido Estomacal','No especifica' => 'No especifica'),), null, ['class' => 'chosen-select', 'required'])!!}
                                                                <small class="form-text text-danger">* El Tipo de Muestra es requerido.</small>
                                                            </p>
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
                                                     <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_entrada" value="<?php echo date('Y-m-d'); ?>">
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
                                                        <label for="localidad">Localidad:</label><br>
                                                        <select class="chosen-select" name="localidad">
                                                            <option disabled selected>Seleccionar Localidad</option>
                                                            @foreach($localidads as $localidad)
                                                            <option value="{{$localidad->id}}">{{$localidad->localidad}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* La Localidad es requerida.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                            <div class="form-group">
                                                <label for="provincia">Provincia:</label>
                                                    <p>
                                                    {!!Form::select('provincia',[null=>'Seleccionar Provincia'] +  array('Sin Identificar' => 'Sin Identificar','C.A.B.A.' => 'C.A.B.A.','Buenos Aires' => 'Buenos Aires','Catamarca' => 'Catamarca','Córdoba' => 'Córdoba','Corrientes' => 'Corrientes','Chaco' => 'Chaco','Chubut' => 'Chubut','Entre Rios' => 'Entre Rios','Formosa' => 'Formosa','Jujuy' => 'Jujuy','La Pampa' => 'La Pampa','La Rioja' => 'La Rioja','Mendoza' => 'Mendoza','Misiones' => 'Misiones','Neuquen' => 'Neuquen','Rio Negro' => 'Rio Negro','Salta' => 'Salta','San Juan' => 'San Juan','San Luis' => 'San Luis','Santa Cruz' => 'Santa Cruz','Santa Fe' => 'Santa Fe','Santiago del Estero' => 'Santiago del Estero','Tucumán' => 'Tucumán','Tierra del Fuego' => 'Tierra del Fuego'), 'Chubut', ['class' => 'chosen-select'])!!}
                                                    <small class="form-text text-danger">* La Provincia es requerida.</small>
                                                    </p>
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
                                                </div>
                                            </div>
                                        <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Conservación:</label>
                                                    <input type="text" class="form-control form-control-sm" name="conservacion">
                                                </div>
                                            </div>
                                            <div class="col">
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
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Cantidad:</label>
                                                    <input type="text" class="form-control form-control-sm" name="cantidad">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Peso/Volúmen:</label>
                                                    <input type="text" class="form-control form-control-sm" name="peso">
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
                                                    <input type="text" class="form-control form-control-sm" name="registro_alim">
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
                                        <div class="row"> 
                                            <div class="col">
                                                <div class="form-group">
                                                    {!! Form::checkbox('microbiologia', true, NULL) !!}   
                                                    <label class="bmd-label-floating">Microbiología:</label>
                                                    
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    {!! Form::checkbox('quimica', true, NULL) !!}
                                                    <label class="bmd-label-floating">Química:</label>
                                                    
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    {!! Form::checkbox('cromatografia', true, NULL) !!}
                                                    <label class="bmd-label-floating">Cromatografía:</label>
                                                    
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                     {!! Form::checkbox('ensayo_biologico', true, NULL) !!}
                                                     <label class="bmd-label-floating">Ensayo Biológico:</label>
                                                   
                                                </div>
                                            </div>
                                        </div>  
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
                                        <div class="row">
                                        <div class="col-md-16">

                                            <div class="form-group">
                                            {!! Form::Label('ensayos', 'Ensayos:') !!}
                                            <select class="chosen-select" name="ensayos[]" id="ensayos" multiple="multiple">
                                                @foreach($ensayos as $ensayo)
                                                <option value="{{$ensayo->id}}">{{$ensayo->ensayo}} / {{$ensayo->matriz->matriz }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
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