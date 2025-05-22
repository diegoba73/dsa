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
                                    <strong class="card-title">Editar Muestra Nº {{$muestra->numero}}</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-prevent-multiple-submit" method="post" action="{{ url('/lab/muestras/'.$muestra->id.'/edit') }}">
                                        {{ csrf_field() }}
                                        <input name="url" type="hidden" value="{{ $url }}">
                                        <div class="row">
                                            @if (Auth::user()->id == 6 || Auth::user()->id == 30)
                                            <div class="col-6">
                                                <div class="form-group">
                                                <label for="departamento_id">Departamento:</label>
                                                            <p>
                                                            {!!Form::select('departamento_id',array('3' => 'DSB','4' => 'DSO'), $muestra->departamento_id, ['class' => 'chosen-select', 'style' => 'width: 70px;'])!!}
                                                            </p>
                                                </div>
                                            </div>
                                            @else
                                            <input type="hidden" value="{{ $muestra->departamento_id }}" name="departamento_id">
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="solicitante">Solicitante:</label><br>
                                                        <select class="chosen-select" name="solicitante" @if($remitente) disabled @endif>
                                                            <option disabled selected>Seleccionar Solicitante</option>
                                                            @foreach($remitentes as $remitente)
                                                            <option value="{{$remitente->nombre}}" @if(($muestra->solicitante) == ($remitente->nombre)) selected="selected" @endif>{{$remitente->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* El Solicitante es requerida.</small>
                                                        <input type="hidden" name="solicitante_hidden" value="{{ $muestra->solicitante }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="entrada">Entrada:</label>
                                                            <p>
                                                            {!!Form::select('entrada', array('DECOMISO' => 'DECOMISO','CONTROL' => 'CONTROL','INTERVENCION' => 'INTERVENCION','DENUNCIA' => 'DENUNCIA','LICITACION' => 'LICITACION','INTOXICACION' => 'INTOXICACION','MUESTREO PROGRAMADO' => 'MUESTREO PROGRAMADO'), $muestra->entrada, ['class' => 'chosen-select', 'disabled' => (auth()->user()->role_id === 13)])!!}
                                                            </p>
                                                            <input type="hidden" name="entrada_hidden" value="CONTROL">
                                                </div> 
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="tipo_prestacion">Tipo de Prestación:</label>
                                                            <p>
                                                            {!!Form::select('tipo_prestacion', array('APS' => 'APS','CONVENIO' => 'CONVENIO','ARANCELADO' => 'ARANCELADO','CALIDAD' => 'CALIDAD'), $muestra->tipo_prestacion, ['class' => 'chosen-select', 'disabled' => (auth()->user()->role_id === 13)])!!}
                                                            </p>
                                                            <input type="hidden" name="tipo_prestacion_hidden" value="ARANCELADO">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="remitente">Remitente:</label><br>
                                                    <select class="chosen-select" name="remitente" @if($remitente && $user->role_id === 13) disabled @endif>
                                                        <option disabled selected>Seleccionar Remitente</option>
                                                        @foreach($remitentes as $remitenteOption)
                                                            <option value="{{$remitenteOption->id}}" @if($muestra->remitente_id === $remitenteOption->id) selected @endif>{{$remitenteOption->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-danger">* El Remitente es requerido.</small>
                                                    <input type="hidden" name="remitente_hidden" value="{{ $muestra->remitente_id }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                            <div class="form-group">
                                            <label for="matriz">Matriz:</label><br>
                                                        <select class="chosen-select" name="matriz_id" id="matriz">
                                                            <option disabled selected>Seleccionar Matriz</option>
                                                            @foreach($matrizs as $matriz)
                                                            <option value="{{$matriz->id}}" @if(($muestra->matriz_id) == ($matriz->id)) selected="selected" @endif>{{$matriz->matriz}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* La matriz es requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="tipomuestra_id">Tipo de Muestra:</label>
                                                        <select class="chosen-select" name="tipomuestra_id" id="tipomuestra">
                                                            <option disabled selected>Seleccionar Tipo de Muestra</option>
                                                            @foreach($tipomuestras as $tipomuestra)
                                                            <option value="{{$tipomuestra->id}}" @if(($muestra->tipomuestra_id) == ($tipomuestra->id)) selected="selected" @endif>{{$tipomuestra->tipo_muestra}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* La matriz es requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Muestra:</label>
                                                    <input type="text" class="form-control form-control-sm" name="muestra" value="{{ $muestra->muestra }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nº Cert. Cadena de Custodia:</label>
                                                    <input type="text" class="form-control form-control-sm" name="cadena custodia" value="{{ $muestra->nro_cert_cadena_custodia }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Identificación:</label>
                                                    <input type="text" class="form-control form-control-sm" name="identificacion" value="{{ $muestra->identificacion }}">
                                                </div>
                                            </div>                                        
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de Entrada:</label>
                                                     <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_entrada" value="{{ $muestra->fecha_entrada }}">
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Realizó Muestreo:</label>
                                                    <input type="text" class="form-control form-control-sm datetimepicker" name="realizo_muestreo" value="{{ $muestra->realizo_muestreo }}">
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
                                                            <option value="{{$provincia->id}}" @if(($muestra->provincia_id) == ($provincia->id)) selected="selected" @endif>{{$provincia->provincia}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* La Provincia es requerida.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="localidad">Localidad:</label><br>
                                                        <select class="chosen-select" name="localidad_id" id="localidad">
                                                            <option disabled selected>Seleccionar Localidad</option>
                                                            @foreach($localidads as $localidad)
                                                            <option value="{{$localidad->id}}" @if(($muestra->localidad_id) == ($localidad->id)) selected="selected" @endif>{{$localidad->localidad}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* La Localidad es requerida.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Lugar de Extracción:</label>
                                                    <input type="text" class="form-control form-control-sm" name="lugar_extraccion" value="{{ $muestra->lugar_extraccion }}">
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de Extracción:</label>
                                                    <input type="date" class="form-control form-control-sm" name="fecha_extraccion" value="{{ $muestra->fecha_extraccion }}">
                                                    <small class="form-text text-danger">* La Fecha es requerida.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Hora Extración:</label>
                                                    <input type="text" class="form-control form-control-sm" name="hora_extraccion" value="{{ $muestra->hora_extraccion }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Conservación:</label>
                                                    <input type="text" class="form-control form-control-sm" name="conservacion" value="{{ $muestra->conservacion }}">
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Cloro:</label>
                                                    <input type="text" class="form-control form-control-sm" name="cloro_residual" value="{{ $muestra->cloro_residual }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Tipo de Envase:</label>
                                                    <input type="text" class="form-control form-control-sm" name="tipo_envase" value="{{ $muestra->tipo_envase }}">
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Cantidad:</label>
                                                    <input type="text" class="form-control form-control-sm" name="cantidad" value="{{ $muestra->cantidad }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Peso/Volúmen:</label>
                                                    <input type="text" class="form-control form-control-sm" name="peso_volumen" value="{{ $muestra->peso_volumen }}">
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
                                                    <input type="text" class="form-control form-control-sm" name="fecha_elaborado" value="{{ $muestra->fecha_elaborado }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Fecha de Vencimiento:</label>
                                                    <input type="text" class="form-control form-control-sm" name="fecha_vencimiento" value="{{ $muestra->fecha_vencimiento }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Elaborado por:</label>
                                                    <input type="text" class="form-control form-control-sm" name="elaborado" value="{{ $muestra->elaborado_por }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Marca:</label>
                                                    <input type="text" class="form-control form-control-sm" name="marca" value="{{ $muestra->marca }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Domicilio</label>
                                                    <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ $muestra->domicilio }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                                        
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Reg. de Establecimiento:</label>
                                                    <input type="text" class="form-control form-control-sm" name="registro_est" value="{{ $muestra->registro_establecimiento }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Reg. de Producto:</label>
                                                    <input type="text" class="form-control form-control-sm" name="registro_prod" value="{{ $muestra->registro_producto }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Lote:</label>
                                                    <input type="text" class="form-control form-control-sm" name="lote" value="{{ $muestra->lote }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Partida:</label>
                                                    <input type="text" class="form-control form-control-sm" name="partida" value="{{ $muestra->partida }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Destino:</label>
                                                    <input type="text" class="form-control form-control-sm" name="destino" value="{{ $muestra->destino }}">
                                                </div>
                                            </div>
                                            @endif
                                        </div>
<!--                                         <div class="border border-danger rounded">
                                        <br>
                                            <div class="row"> 
                                                <div class="col">
                                                    <div class="form-group ml-4">
                                                        {!! Form::checkbox('microbiologia', true, $muestra->microbiologia) !!}   
                                                        <label class="bmd-label-floating">Microbiología:</label>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {!! Form::checkbox('quimica', true, $muestra->quimica) !!}
                                                        <label class="bmd-label-floating">Química:</label>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {!! Form::checkbox('cromatografia', true, $muestra->cromatografia) !!}
                                                        <label class="bmd-label-floating">Cromatografía:</label>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {!! Form::checkbox('ensayo_biologico', true, $muestra->ensayo_biologico) !!}
                                                        <label class="bmd-label-floating">Ensayo Biológico:</label>
                                                    
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="row"> 
                                                <small class="form-text text-danger ml-4">* El campo de Área analítica al menos debe tener 1 seleccionado.</small>
                                            </div>
                                        </div> -->
                                        <br>
                                        @if (Auth::user()->departamento_id == 1)
                                        <div class="row">                                                                                                                                 
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Aceptada:</label>
                                                    {!! Form::checkbox('aceptada', true, $muestra->aceptada) !!}
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
                                            {!! Form::Label('ensayo_id', 'Ensayos:') !!}
                                            <select class="chosen-select" name="ensayo_id[]" id="ensayos" multiple="multiple" style="width: 950px">
                                            @forelse($selects as $sel)
                                                @foreach($ensayos as $ensayo)
                                                <option value="{{$ensayo->id}}" @if(($sel->ensayo_id) == ($ensayo->id)) selected="selected" @endif>{{$ensayo->ensayo}} / {{$ensayo->norma_procedimiento}}</option>
                                                @endforeach
                                            @empty
                                                @foreach($ensayos as $ensayo)
                                                <option value="{{$ensayo->id}}">{{$ensayo->ensayo}} / {{$ensayo->norma_procedimiento}}</option>
                                                @endforeach
                                            @endforelse
                                            </select>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                                <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>Actualizar</button>
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