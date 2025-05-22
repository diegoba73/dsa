@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'dsa.pedidos.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Ingreso de Pedido</strong>
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
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/dsa/pedidos') }}">
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
                                        @if (Auth::user()->departamento_id == 1)
                                        <div><button type="button" class="btn btn-info" id="btn_reactivos">Reactivos</button><button type="button" class="btn btn-info" id="btn_insumos">Insumos</button><button type="button" class="btn btn-info" id="btn_articulos">Artículos</button></div>
                                        
                                        <div class="show" id="reactivos">
                                        <table class="table table-bordered" id="item_tableR">
                                            <tr>
                                            <th>Reactivo</th>
                                            <th>Cantidad</th>
                                            <th><button type="button" name="addR" class="btn btn-success btn-sm addR"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                        </table>
                                        </div>
                                        <div style="display:none;" id="insumos">
                                        <table class="table table-bordered" id="item_tableI">
                                            <tr>
                                            <th>Insumo</th>
                                            <th>Cantidad</th>
                                            <th><button type="button" name="addI" class="btn btn-success btn-sm addI"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                        </table>
                                        </div>
                                        <div style="display:none;" id="articulos">
                                        <table class="table table-bordered" id="item_tableA">
                                            <tr>
                                            <th>Artículo</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unidad</th>
                                            <th><button type="button" name="addA" class="btn btn-success btn-sm addA"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                        </table>
                                        </div>
                                        @else
                                        <div class="alert alert-default">
                                            <strong>Pedido de Compra</strong>
                                        </div>
                                        <table class="table table-bordered" id="item_tableA">
                                            <tr>
                                            <th>Artículo</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th><button type="button" name="addA" class="btn btn-success btn-sm addA"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                        </table>

                                        @endif          
                                        <a class="btn btn-default btn-close" href="{{ route('pedido_index') }}">Cancel</a>          
                                        <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    Ingresar
                                        </button>
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

<script>
$(document).ready(function(){
 
 $(document).on('click', '.addR', function(){

  var html = '';
  
  html += '<tr>';
  
  html += '<td><select class="chosen-select" name="reactivo[]">@foreach($reactivos as $reactivo)<option value="{{$reactivo->id}}">{{$reactivo->nombre}} / {{$reactivo->descripcion}}</option>@endforeach</select></td>';

  html += '<td><input type="text" name="cantidad[]" class="form-control form-control-sm" /></td>';
  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td></tr>';

  $('#item_tableR').append(html);
  $('.chosen-select').chosen();
 });

 $(document).on('click', '.addI', function(){

    var html = '';

    html += '<tr>';

    html += '<td><select class="chosen-select" name="insumo[]">@foreach($insumos as $insumo)<option value="{{$insumo->id}}">{{$insumo->nombre}} </option>@endforeach</select></td>';

    html += '<td><input type="text" name="cantidad[]" class="form-control form-control-sm" /></td>';
    html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td></tr>';


    $('#item_tableI').append(html);
    $('.chosen-select').chosen();
});

$(document).on('click', '.addA', function(){

    var html = '';

    html += '<tr>';

    html += '<td><input type="text" name="item[]" class="form-control form-control-sm" /></td>';

    html += '<td><input type="text" name="cantidad[]" class="form-control form-control-sm" /></td>';

    html += '<td><input type="text" name="precio[]" class="form-control form-control-sm" /></td>';

    html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td></tr>';


    $('#item_tableA').append(html);
});


 $(document).on('click', '.remove', function(){
  $(this).closest('tr').remove();
 });

})

$( document ).ready(function() {
    $( "#btn_reactivos" ).click(function() {
        $('#reactivos').show(); 
        $('#insumos').hide(); 
        $('#articulos').hide(); 
    });

    $( "#btn_insumos" ).click(function() {
        $('#insumos').show(); 
        $('#reactivos').hide(); 
        $('#articulos').hide(); 
    });
    $( "#btn_articulos" ).click(function() {
        $('#articulos').show(); 
        $('#reactivos').hide(); 
        $('#insumos').hide(); 
    });
});
 </script>  
@endsection