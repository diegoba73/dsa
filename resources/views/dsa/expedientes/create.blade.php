@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'dsa.expedientes.create', 'title' => __('Sistema DPSA')])
@section('content')
{{ Form::hidden('url', URL::full()) }}
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                                    <strong class="card-title">Ingreso de Expediente</strong>
                                </div>
                                <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/dsa/expedientes') }}">
                                    {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="bmd-label-floating">Nº Nota:</label>
                                                <input type="text" class="form-control form-control-sm" name="nro_nota">
                                                
                                            </div>
                                            <div class="col-md-2">
                                                <br>
                                                
                                                <a href="#" class="btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#agregarnota">
                                                    Nº Nota
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Descripción:</label>
                                            <input type="text" class="form-control form-control-sm" name="descripcion">
                                            <small class="form-text text-danger">* La Descripción es requerida.</small>
                                        </div>
                                        <div class="row">
                                            <table class="table table-bordered">
                                            <tr>
                                            <th>Item</th>
                                            <th>Cantidad Pedida</th>
                                            <th>Monto</th>
                                            <th>Agregar al expediente</th>

                                            </tr>
                                            <!-- Código HTML anterior -->
                                            <!-- Código HTML anterior -->

                                            @foreach ($reactivos_pedidos as $reactivo)
                                                <tr>
                                                    <td>
                                                        <select class="chosen-select" name="reactivo[]">
                                                            @foreach ($reactivos as $r)
                                                                <option value="{{$r->id}}" @if ($reactivo->reactivo_id == $r->id) selected @endif>{{$r->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="cantidad_pedida[]" class="form-control form-control-sm" value="{{$reactivo->cantidad_pedida}}"/></td>
                                                    <td>
                                                        @foreach ($reactivos_seleccionados as $r_seleccionado)
                                                            @if ($reactivo->reactivo_id == $r_seleccionado->id)
                                                                {{$reactivo->cantidad_pedida * $r_seleccionado->costo}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                        <td><input type="checkbox" name="aceptado_reactivo[]" value="{{$reactivo->id}}" @if ($reactivo->aceptado) checked @endif/></td>
                                                </tr>
                                            @endforeach

                                            @foreach ($insumos_pedidos as $insumo)
                                                <tr>
                                                    <td>
                                                        <select class="chosen-select" name="insumo[]">
                                                            @foreach ($insumos as $i)
                                                                <option value="{{$i->id}}" @if ($insumo->insumo_id == $i->id) selected @endif>{{$i->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="cantidad_pedida[]" class="form-control form-control-sm" value="{{$insumo->cantidad_pedida}}"/></td>
                                                    <td>
                                                        @foreach ($insumos_seleccionados as $i_seleccionado)
                                                            @if ($insumo->insumo_id == $i_seleccionado->id)
                                                                {{$insumo->cantidad_pedida * $i_seleccionado->costo}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                        <td><input type="checkbox" name="aceptado_insumo[]" value="{{$insumo->id}}" @if ($insumo->aceptado) checked @endif/></td>
                                                </tr>
                                            @endforeach

                                            @foreach ($articulos as $articulo)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="item[]" class="form-control form-control-sm" value="{{ $articulo->item }}" >
                                                    </td>
                                                    <td>
                                                        <input type="number" name="cantidad[]" class="form-control form-control-sm" value="{{ $articulo->cantidad }}" >
                                                    </td>
                                                    <td>
                                                        @foreach ($articulos as $a_seleccionado)
                                                            @if ($articulo->id == $a_seleccionado->id)
                                                                {{$articulo->cantidad * $a_seleccionado->precio}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                        <td><input type="checkbox" name="aceptado_articulo[]" value="{{$articulo->id}}" @if ($articulo->aceptado) checked @endif/></td>
                                                </tr>
                                            @endforeach

                                            </table>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                                    <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        Ingresar
                                                    </button>
                                                </div>
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

<!-- Modal -->

<div class="modal fade" id="agregarnota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Agregar NºNota</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
        <form action="{{route('notapedido')}}" method="post">
      		{{csrf_field()}}
	      <div class="modal-body">

            <div class="form-group">
                <div class="form-group">
                <label class="control-label col-sm-6"for="fecha">Fecha</label>
                    <div class="col-sm-6">
                    <input type="date" class="form-control form-control-sm" name="fecha">
                    </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-6"for="descripcion">Descripción</label>
                    <div class="col-sm-6">
                    <input type="name" class="form-control form-control-sm" name="descripcion">
                    </div>
                </div>
            </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar</button>
	      </div>
        </form>
    </div>
  </div>
</div>

<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
@endsection