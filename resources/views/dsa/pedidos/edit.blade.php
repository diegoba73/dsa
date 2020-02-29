@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.pedidos.edit', 'title' => __('Sistema DPSA')])
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
                                                    <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_pedido" value="{{ $pedido->fecha_pedido }}">
                                                    <small class="form-text text-danger">* La Fecha de pedido es requerida.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label class="bmd-label-floating">Descripción:</label>
                                            <input type="text" class="form-control form-control-sm" name="descripcion" value="{{ $pedido->descripcion }}">
                                            <small class="form-text text-danger">* La Descripción es requerida.</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Pasado a:</label>
                                                    <input type="text" class="form-control form-control-sm" name="pasado_a" value="{{ $pedido->pasado_a }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de pase:</label>
                                                        <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_pase" value="{{ $pedido->fecha_pase }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nº de nota:</label>
                                                    <input type="text" class="form-control form-control-sm" name="nro_nota" value="{{ $pedido->nro_nota }}">
                                                </div>
                                            </div>
                                            @if (Auth::user()->departamento_id == 5)
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nº Exp.:</label>
                                                    <input type="text" class="form-control form-control-sm" name="nro_expediente" value="{{ $pedido->nro_expediente }}">
                                                </div>
                                            </div>
                                            @else
                                            @endif
                                        </div>
                                        @if (Auth::user()->departamento_id == 5)
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::checkbox('entrega_parcial', true, $pedido->entrega_parcial) !!}   
                                                    <label class="bmd-label-floating">Entrega Parcial:</label>
                                                    
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::checkbox('rechazado', true, $pedido->rechazado) !!}   
                                                    <label class="bmd-label-floating">Rechazado:</label>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::checkbox('finalizado', true, $pedido->finalizado) !!}   
                                                    <label class="bmd-label-floating">Finalizado:</label>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col">
                                                <div class="form-group"> 
                                                    <label class="bmd-label-floating">Observaciones:</label>
                                                    <input type="text" class="form-control form-control-sm" name="observaciones" value="{{ $pedido->observaciones }}">                                                    
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        @endif
                                        <div class="row">
                                        @if (Auth::user()->departamento_id == 5)

                                            <table class="table table-bordered">
                                            <tr>
                                            <th>Item</th>
                                            <th>Cantidad Pedida</th>
                                            <th>Cantidad Entregada</th>
                                            
                                            </tr>
                                            @foreach ($pedido->reactivos as $reactivo)
                                            <tr><td><input type="hidden" name="reactivo[]" value="{{ $reactivo->id }}" >{{$reactivo->nombre}}</td><td>{{$reactivo->pivot->cantidad_pedida}}</td><td><input type="text" style="width:100px" class="form-control form-control-sm" name="cantidad_entregada[]" value="{{ $reactivo->pivot->cantidad_entregada }}"></td></tr>
                                            @endforeach
                                            @foreach ($pedido->insumos as $insumo)
                                            <tr><td><input type="hidden" name="insumo[]" value="{{ $insumo->id }}" >{{$insumo->nombre}}</td><td>{{$insumo->pivot->cantidad_pedida}}</td><td><input type="text" style="width:100px" class="form-control form-control-sm" name="cantidad_entregada[]" value="{{ $insumo->pivot->cantidad_entregada }}"></td></tr>
                                            @endforeach
                                            @foreach ($articulos as $articulo)
                                            <tr><td><input type="hidden" name="item[]" value="{{ $articulo->id }}" >{{$articulo->item}}</td><td>{{$articulo->cantidad}}</td><td><input type="text" style="width:100px" class="form-control form-control-sm" name="cantidad_entregada[]" value="{{ $articulo->cantidad_entregada }}"></tr>
                                            @endforeach
                                            </table>
                                            @elseif (Auth::user()->departamento_id == 1)
                                            <table class="table table-bordered">
                                            <tr>
                                            <th>Item</th>
                                            <th>Cantidad Pedida</th>
                                            <th>Cantidad Entregada</th>

                                            </tr>
                                            @foreach ($pedido->reactivos as $reactivo)
                                            <tr><td><input type="hidden" name="reactivo[]" value="{{ $reactivo->id }}" >{{$reactivo->nombre}}</td><td>{{$reactivo->pivot->cantidad_pedida}}</td><td>{{ $reactivo->pivot->cantidad_entregada }}</td></tr>
                                            @endforeach
                                            @foreach ($pedido->insumos as $insumo)
                                            <tr><td><input type="hidden" name="insumo[]" value="{{ $insumo->id }}" >{{$insumo->nombre}}</td><td>{{$insumo->pivot->cantidad_pedida}}</td><td>{{ $insumo->pivot->cantidad_entregada }}</td></tr>
                                            @endforeach
                                            @foreach ($articulos as $articulo)
                                            <tr><td><input type="hidden" name="item[]" value="{{ $articulo->id }}" >{{$articulo->item}}</td><td>{{$articulo->cantidad}}</td><td>{{ $articulo->cantidad_entregada }}</tr>
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
                                        <a class="btn btn-default btn-close" href="{{ url('/dsa/pedidos/'.$pedido->id.'/show')}}">Cancelar</a>
                                        <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    Actualizar
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