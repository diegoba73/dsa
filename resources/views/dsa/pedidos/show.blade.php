@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.ensayos.edit', 'title' => __('Sistema DPSA')])
@section('content')
{{ Form::hidden('url', URL::full()) }}
<div class="header bg-primary pb-8 pt-5 pt-md-6">
        <div class="container-fluid">

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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="alert alert-default">
                                    <strong class="card-title">Pedido Nº {{$pedido->nro_pedido}}</strong>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ url('/dsa/pedidos/'.$pedido->id.'/edit') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="label-control">Fecha de pedido:</label>
                                                    <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_pedido" value="{{ $pedido->fecha_pedido }}" readonly>
                                                    <small class="form-text text-danger">* La Fecha de pedido es requerida.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label class="bmd-label-floating">Descripción:</label>
                                            <input type="text" class="form-control form-control-sm" name="descripcion" value="{{ $pedido->descripcion }}" readonly>
                                            <small class="form-text text-danger">* La Descripción es requerida.</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Pasado a:</label>
                                                    <input type="text" class="form-control form-control-sm" name="pasado_a" value="{{ $pedido->pasado_a }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de pase:</label>
                                                        <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_pase" value="{{ $pedido->fecha_pase }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nº de nota:</label>
                                                    <input type="text" class="form-control form-control-sm" name="nro_nota" value="{{ $pedido->nro_nota }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nº Exp.:</label>
                                                    <input type="text" class="form-control form-control-sm" name="nro_expediente" value="{{ $pedido->nro_expediente }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::checkbox('entrega_parcial', true, $pedido->entrega_parcial, array('disabled' => 'true')) !!}   
                                                    <label class="bmd-label-floating">Entrega Parcial:</label>
                                                    
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::checkbox('rechazado', true, $pedido->rechazado, array('disabled' => 'true')) !!}   
                                                    <label class="bmd-label-floating">Rechazado:</label>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::checkbox('finalizado', true, $pedido->finalizado, array('disabled' => 'true')) !!}   
                                                    <label class="bmd-label-floating">Finalizado:</label>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                                <div class="form-group"> 
                                                    <label class="bmd-label-floating">Observaciones:</label>
                                                    <input type="text" class="form-control form-control-sm" name="observaciones" value="{{ $pedido->observaciones }}" readonly>                                                    
                                                </div>
                                        </div>
                                        <div class="row">
                                        @if (Auth::user()->departamento_id == 1 || Auth::user()->departamento_id == 5)

                                            <table class="table table-bordered">
                                            <tr>
                                            <th>Item</th>
                                            <th>Cantidad</th>
                                            
                                            </tr>
                                            @foreach ($pedido->reactivos as $reactivo)
                                            <tr><td>{{$reactivo->nombre}}</td><td>{{$reactivo->pivot->cantidad_pedida}}</td></tr>
                                            @endforeach
                                            @foreach ($pedido->insumos as $insumo)
                                            <tr><td>{{$insumo->nombre}}</td><td>{{$insumo->pivot->cantidad_pedida}}</td></tr>
                                            @endforeach
                                            @foreach ($articulos as $articulo)
                                            <tr><td>{{$articulo->item}}</td><td>{{$articulo->cantidad}}</td></tr>
                                            @endforeach
                                            </table>
                                        
                                        @else
                                            <table class="table table-bordered">
                                                <tr>
                                                <th>Item</th>
                                                <th>Cantidad</th>
                                                
                                                </tr>
                                            @foreach ($articulos as $articulo)
                                            <tr><td>{{$articulo->item}}</td><td>{{$articulo->cantidad}}</td></tr>
                                            @endforeach
                                            </table>
                                        @endif
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <a class="btn btn-default btn-close" href="{{ route('pedido_index') }}">Cancelar</a>
                                                <a class="btn btn-primary btn-close" href="{{ url('/dsa/pedidos/'.$pedido->id.'/edit')}}">Editar</a>
                                                <a class="btn btn-success btn-close" href="{{ url('/dsa/pedidos/'.$pedido->id.'/imprimir')}}" target="_blank">Imprimir</a>
                                                <a class="btn btn-danger btn-close" href="{{ url('/dsa/pedidos/'.$pedido->id.'/destroy')}}" onclick="return confirm('Seguro quiere Eliminar?')">Eliminar</a>
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