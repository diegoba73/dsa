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
                                    <form method="POST" action="{{ url('/dsa/pedidos/'.$pedido->id.'/edit') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="label-control">Fecha de pedido:</label>
                                                    <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_pedido" value="{{ $pedido->fecha_pedido }}">
                                                    <small class="form-text text-danger">* La Fecha de pedido es requerida.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nº de nota:</label>
                                                    <input type="text" class="form-control form-control-sm" name="nro_nota" value="{{ $pedido->nro_nota }}">
                                                </div>
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Estado:</label>
                                                    <p>
                                                    {!!Form::select('estado', array('INICIO' => 'INICIO','SOLICITUD DE EXPEDIENTE' => 'SOLICITUD DE EXPEDIENTE','ADJUDICACION' => 'ADJUDICACION','ENTREGA PARCIAL' => 'ENTREGA PARCIAL','ENTREGA TOTAL' => 'ENTREGA TOTAL','BAJA' => 'BAJA'), $pedido->estado, ['class' => 'chosen-select'])!!}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha expediente:</label>
                                                        <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_expediente" value="{{ $pedido->fecha_expediente }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nº Exp.:</label>
                                                    <input type="text" class="form-control form-control-sm" name="nro_expediente" value="{{ $pedido->nro_expediente }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group text-center">
                                                    <label class="bmd-label-floating">Finalizado:</label>
                                                    <br>
                                                    <div class="form-check form-check-inline mx-auto">
                                                        {!! Form::checkbox('finalizado', true, $pedido->finalizado, ['class' => 'form-check-input form-check-input-lg']) !!}
                                                    </div>
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
                                        <div class="row">
                                            <table class="table table-bordered">
                                            <tr>
                                            <th>Item</th>
                                            <th>Cantidad Pedida</th>
                                            <th>Cantidad Entregada</th>

                                            </tr>
                                            @foreach ($pedido->reactivos as $reactivo)
                                                <tr>
                                                    <td>
                                                        <select class="chosen-select" name="reactivo[]">
                                                            @foreach ($reactivos as $r)
                                                                <option value="{{$r->id}}" @if ($reactivo->id == $r->id) selected @endif>{{$r->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="cantidad_pedida[]" class="form-control form-control-sm" value="{{$reactivo->pivot->cantidad_pedida}}"/></td>
                                                    <td><input type="text" name="cantidad_entregada[]" class="form-control form-control-sm" value="{{ $reactivo->pivot->cantidad_entregada }}"/></td>
                                                </tr>
                                            @endforeach
                                            @foreach ($pedido->insumos as $insumo)
                                                <tr>
                                                    <td>
                                                        <select class="chosen-select" name="insumo[]">
                                                            @foreach ($insumos as $i)
                                                                <option value="{{$i->id}}" @if ($insumo->id == $i->id) selected @endif>{{$i->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="cantidad_pedida[]" class="form-control form-control-sm" value="{{$insumo->pivot->cantidad_pedida}}"/></td>
                                                    <td><input type="text" name="cantidad_entregada[]" class="form-control form-control-sm" value="{{ $insumo->pivot->cantidad_entregada }}"/></td>
                                                </tr>
                                            @endforeach
                                            @foreach ($articulos as $articulo)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="item[]" class="form-control form-control-sm" value="{{ $articulo->id }}" >
                                                        {{ $articulo->item }}
                                                    </td>
                                                    <td>
                                                        <input type="number" name="cantidad[]" class="form-control form-control-sm" value="{{ $articulo->cantidad }}" >
                                                    </td>
                                                    <td>
                                                        <input type="number" name="cantidad_entregada[]" class="form-control form-control-sm" value="{{ $articulo->cantidad_entregada }}" >
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </table>
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