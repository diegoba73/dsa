@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.insumos.stock', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Ingreso Stock Insumo</strong>
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
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/lab/insumos/'.$insumo->id.'/stock') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                    <div class="row">
                                    <input name="url" type="hidden" value=$url>
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr><strong>
                                                    <th>Codigo</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>                                                   
                                                </strong>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> {{ $insumo->codigo }} </td>
                                                    <td> {{ $insumo->nombre }} </td>
                                                    <td> {{ $insumo->descripcion }} </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                                      
                                        <table class="table rounded">
                                            <thead class="thead-dark">
                                                <tr><strong>
                                                    <th>Registro</th>
                                                    <th>Fecha Entrada</th>
                                                    <th>Fecha Baja</th>
                                                    <th>Cantidad</th>
                                                    <th>Almacenamiento</th>
                                                    <th style="text-align:center;">En Uso</th>
                                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 8)
                                                    <th style="text-align:center;">Area</th>
                                                    @else
                                                    @endif
                                                    <th>
                                                    <th>
                                                    </strong>
                                                    <a href="#" class="btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#agregar">
                                                    <i class="fas fa-plus"></i>
                                                        </a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                @foreach ($stock_insumos as $stock_insumo)
                                                <tr>
                                                    <td> {{ $stock_insumo->registro }} </td>
                                                    @if (strtotime($stock_insumo->fecha_entrada) > 0)
                                                    <td> {{ date('d-m-Y', strtotime($stock_insumo->fecha_entrada)) }} </td>
                                                    @else
                                                    <td></td>
                                                    @endif
                                                    @if (strtotime($stock_insumo->fecha_baja) > 0)
                                                    <td> {{ date('d-m-Y', strtotime($stock_insumo->fecha_baja)) }} </td>
                                                    @else
                                                    <td></td>
                                                    @endif
                                                    <td> {{ $stock_insumo->cantidad }} </td>
                                                    <td> {{ $stock_insumo->almacenamiento }} </td>
                                                    @if (empty($stock_insumo->fecha_baja))
                                                    <td style="text-align:center;"><i class="fas fa-check-square fa-2x text-green"></i></td>
                                                    @else
                                                    <td></td>
                                                    @endif
                                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 8)
                                                    <td style="text-align:center;"> {{ $stock_insumo->area }} </td>
                                                    @else
                                                    @endif
                                                    <td>
                                                        <a href="#" class="btn btn-warning btn-round btn-sm" data-siid="{{$stock_insumo->id}}" data-siregistro="{{$stock_insumo->registro}}" data-sientrada="{{$stock_insumo->fecha_entrada}}" data-sicantidad="{{$stock_insumo->cantidad}}" data-sibaja="{{$stock_insumo->fecha_baja}}" data-simarca="{{$stock_insumo->marca}}" data-sialmacenamiento="{{$stock_insumo->almacenamiento}}" data-sicertificado="{{$stock_insumo->certificado}}" data-siobservaciones="{{$stock_insumo->observaciones}}" data-siproveedor_id="{{$stock_insumo->proveedor_id}}" data-sipedido="{{$stock_insumo->pedido}}" data-siarea="{{$stock_insumo->area}}" data-toggle="modal" data-target="#editarsi">
                                                        <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-danger btn-round btn-sm" data-siid="{{$stock_insumo->id}}" data-siregistro="{{$stock_insumo->registro}}" data-sientrada="{{$stock_insumo->fecha_entrada}}" data-sicantidad="{{$stock_insumo->cantidad}}" data-sibaja="{{$stock_insumo->fecha_baja}}" data-simarca="{{$stock_insumo->marca}}" data-sialmacenamiento="{{$stock_insumo->almacenamiento}}" data-sicertificado="{{$stock_insumo->certificado}}" data-siobservaciones="{{$stock_insumo->observaciones}}" data-siproveedor_id="{{$stock_insumo->proveedor_id}}" data-sipedido="{{$stock_insumo->pedido}}" data-siarea="{{$stock_insumo->area}}" data-toggle="modal" data-target="#eliminarsi">
                                                        <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            
                                            </tbody>
                                            
                                        </table>   
                                        <br>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                    <a class="btn btn-default btn-close" href="{{ route('lab_insumos_index') }}">Cerrar</a>
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

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Agregar Insumo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
        <form action="{{route('stock_insumo.store')}}" method="post">
      		{{csrf_field()}}
        
	      <div class="modal-body">
            <div class="form-group">
            <input type="hidden" class="form-control" name="id" value="{{$insumo->id}}">
            <div class="row">
                <div class="col-7">
                    <label class="control-label col-sm"for="proveedor_id">Proveedor</label>
                        <div class="form-group">
                        <select class="form-control form-control-sm" name="proveedor_id"> @foreach($proveedors as $proveedor)<option value="{{$proveedor->id}}">{{$proveedor->empresa}}</option>@endforeach </select>
                        </div>
                </div>
                <div class="col-2">
                    <label class="control-label col-sm"for="pedido">Pedido</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="pedido">
                        </div>
                </div>
                <div class="col-3">
                    <label class="control-label col-sm"for="registro">Registro</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="registro">
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="fecha_entrada">Fecha Entrada</label>
                    <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="fecha_entrada">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm"for="fecha_baja">Fecha de Baja</label>
                    <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="fecha_baja">
                    </div>
                </div>
                <div class="col-4">
                <label class="control-label col-sm"for="cantidad">Cantidad</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="cantidad" id="cantidad">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                <label class="control-label col-sm-6"for="marca">Marca</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="marca">
                    </div>
                </div>
                <div class="col-4">
                <label class="control-label col-sm-6"for="almacenamiento">Almacenamiento:</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="almacenamiento">
                    </div>
                </div>
                <div class="col-4">
                <label class="control-label col-sm"for="certificado">Certificado</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="certificado" id="certificado">
                    </div>
                </div>
            </div>
            <div class="row">
                @if (Auth::user()->role_id == 3)
                <div style="display:none">
                        <input type="text" name="area" value="QUIMICA ALIMENTOS">
                </div>
                @elseif (Auth::user()->role_id == 4)
                <div style="display:none">
                        <input type="text" name="area" value="QUIMICA AGUAS">
                </div>
                @elseif (Auth::user()->role_id == 5)
                <div style="display:none">
                        <input type="text" name="area" value="ENSAYO BIOLOGICO">
                </div>
                @elseif (Auth::user()->role_id == 6)
                <div style="display:none">
                        <input type="text" name="area" value="CROMATOGRAFIA">
                </div>
                @elseif (Auth::user()->role_id == 7)
                <div style="display:none">
                        <input type="text" name="area" value="MICROBIOLOGIA">
                </div>
                @elseif (Auth::user()->role_id == 1 || Auth::user()->role_id == 8)
                <div class="col">
                    <div class="form-group">
                        <label for="area">Area:</label>
                            <p>
                            {!!Form::select('area',[null=>'Seleccionar Area'] + array('CROMATOGRAFIA' => 'CROMATOGRAFIA','QUIMICA ALIMENTOS' => 'QUIMICA ALIMENTOS', 'QUIMICA AGUAS' => 'QUIMICA AGUAS','ENSAYO BIOLOGICO' => 'ENSAYO BIOLOGICO','MICROBIOLOGIA' => 'MICROBIOLOGIA'), null, ['class' => 'form-control-sm'])!!}
                            <small class="form-text text-danger">* Campo Obligatorio.</small>
                            </p>
                    </div> 
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                <label class="control-label col-sm-6"for="observaciones">Observaciones:</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="observaciones">
                    </div>
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

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="editarsi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Editar Insumo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{route('stock_insumo.update', 'id')}}" method="post">
      		{{method_field('patch')}}
      		{{csrf_field()}}
	      <div class="modal-body">
                <div class="form-group">
                <input name="url" type="hidden" value="{{ $url }}">
                    <input type="hidden" class="form-control" name="id" id="id" value="">
            
            <div class="row">
                <div class="col-7">
                    <label class="control-label col-sm"for="proveedor_id">Proveedor</label>
                        <div class="form-group">
                        <select class="form-control form-control-sm" name="proveedor_id" id="proveedor_id"> @foreach($proveedors as $proveedor)<option value="{{$proveedor->id}}">{{$proveedor->empresa}}</option>@endforeach </select>
                        </div>
                </div>
                <div class="col-2">
                    <label class="control-label col-sm"for="pedido">Pedido</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="pedido" id="pedido">
                        </div>
                </div>
                <div class="col-3">
                    <label class="control-label col-sm"for="registro">Registro</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="registro" id="registro">
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="fecha_entrada">Fecha Entrada</label>
                    <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="fecha_entrada" id="entrada">
                    </div>
                </div>
                <div class="col-3">
                <label class="control-label col-sm"for="fecha_baja">Fecha de Baja</label>
                    <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="fecha_baja" id="baja">
                    </div>
                </div>
                <div class="col-4">
                <label class="control-label col-sm"for="contenido">Cantidad</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="cantidad" id="cantidad">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                <label class="control-label col-sm-6"for="marca">Marca</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="marca" id="marca">
                    </div>
                </div>
                <div class="col-4">
                <label class="control-label col-sm-4"for="almacenamiento">Almacenamiento</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="almacenamiento" id="almacenamiento">
                    </div>
                </div>
                <div class="col-4">
                <label class="control-label col-sm-6"for="certificado">Certificado:</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="certificado" id="certificado">
                    </div>
                </div>
            </div>
            <div class="row">
                @if (Auth::user()->role_id == 3)
                <div style="display:none">
                        <input type="text" name="area" id="area" value="QUIMICA ALIMENTOS">
                </div>
                @elseif (Auth::user()->role_id == 4)
                <div style="display:none">
                        <input type="text" name="area" id="area" value="QUIMICA AGUAS">
                </div>
                @elseif (Auth::user()->role_id == 5)
                <div style="display:none">
                        <input type="text" name="area"  id="area" value="ENSAYO BIOLOGICO">
                </div>
                @elseif (Auth::user()->role_id == 6)
                <div style="display:none">
                        <input type="text" name="area" id="area" value="CROMATOGRAFIA">
                </div>
                @elseif (Auth::user()->role_id == 7)
                <div style="display:none">
                        <input type="text" name="area" id="area" value="MICROBIOLOGIA">
                </div>
                @elseif (Auth::user()->role_id == 1 || Auth::user()->role_id == 8)
                <div class="col">
                    <div class="form-group">
                        <label for="area">Area:</label>
                            <select class="form-control form-control-sm" name="area" id="area">
                            <option value="CROMATOGRAFIA">CROMATOGRAFIA</option>
                            <option value="QUIMICA ALIMENTOS">QUIMICA ALIMENTOS</option>
                            <option value="QUIMICA AGUAS">QUIMICA AGUAS</option>
                            <option value="ENSAYO BIOLOGICO">ENSAYO BIOLOGICO</option>
                            <option value="MICROBIOLOGIA">MICROBIOLOGIA</option>
                            </select>
                    </div> 
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                <label class="control-label col-sm-6"for="observaciones">Observaciones:</label>
                    <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="observaciones" id="observaciones">
                    </div>
                </div>
            </div>


                </div>
                <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <br>
	      </div>
	      </div>
	     
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal-danger fade" id="eliminarsi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title text-center" id="myModalLabel">Eliminar Insumo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
      <form action="{{route('stock_insumo.destroy', 'test')}}" method="post">
      		{{method_field('delete')}}
      		{{csrf_field()}}
	      <div class="modal-body">
            <div class="form-group">
            <input name="url" type="hidden" value="{{ $url }}">
                <input type="hidden" class="form-control" name="id" id="id" value="">
                <div class="form-group">
                <p class="text-center">
					Se eliminará el insumo selecciondo.
				</p>
                </div>
	        </div>
        </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
      </form>
    </div>
  </div>
</div>

@endsection