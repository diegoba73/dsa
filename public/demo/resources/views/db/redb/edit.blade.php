@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.redb.create', 'title' => __('Sistema DPSA')])
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
                        
                        <div class="col-md-12">
                            <div class="card">
                                <div class="alert alert-default">
                                    <strong class="card-title">Actualizando Registro R.E.D.B. {{$redb->razon}}</strong>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('db_redb_update', $redb->id) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        @method('PUT')
                                        <div class="row">
                                            @if ((Auth::user()->departamento_id = 2) && (Auth::user()->role_id <> 15))
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nro de Expediente:</label>
                                                    <input type="text" class="form-control form-control-sm" name="expediente" value="{{ $redb->expediente}}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <br>
                                                <a href="#" class="btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#agregarexp">
                                                    Nº Expediente
                                                </a>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <div class="col">
                                                    <label class="label-control">Fecha de Inscripción:</label>
                                                    <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_inscripcion" value="{{ $redb->fecha_inscripcion ? date('Y-m-d', strtotime($redb->fecha_inscripcion)) : date('Y-m-d') }}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Razón:</label>
                                                <input type="text" class="form-control form-control-sm" name="razon" value="{{ $redb->razon }}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Domicilio:</label>
                                                <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ $redb->domicilio }}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="localidad">Localidad:</label><br>
                                                        <select class="chosen-select" name="localidad_id" id="localidad" {{ (Auth::user()->role_id !== 15) ? 'disabled' : '' }}>
                                                            <option disabled selected>Seleccionar Localidad</option>
                                                            @foreach($localidads as $localidad)
                                                            <option value="{{$localidad->id}}" @if(($redb->localidad_id) == ($localidad->id)) selected="selected" @endif>{{$localidad->localidad}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* La Localidad es requerida.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="rubros">
                                            <table class="table table-bordered" style="margin-bottom: 80px;" id="item_tableR">
                                                <tr>
                                                    <th>Rubro</th>
                                                    <th>Categorías</th>
                                                    <th>Actividades</th>
                                                    <th>
                                                        @if (Auth::user()->role_id == 15)
                                                        <button type="button" name="addR" class="btn btn-success btn-sm addR"><i class="fas fa-plus"></i></button>
                                                        @endif
                                                    </th>
                                                </tr>
                                                @foreach($redb->rubros as $rubro)
                                                <tr>
                                                    <td style="width: 200px;">
                                                        @foreach($dbrubros as $r)
                                                            @if($r->id == $rubro->pivot->dbrubro_id)
                                                                <input type="text" name="rubro[]" class="form-control form-control-sm" value="{{ $r->id }}" style="display: none;">{{ $r->rubro }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($dbcategorias as $cat)
                                                            @if($cat->id == $rubro->pivot->dbcategoria_id)
                                                                <input type="text" name="categoria[]" class="form-control form-control-sm" value="{{ $cat->id }}" style="display: none;">{{ $cat->categoria }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td><input type="text" name="actividad[]" class="form-control form-control-sm" value="{{ $rubro->pivot->actividad }}"style="display: none;">{{ $rubro->pivot->actividad }}</td>
                                                    @if (Auth::user()->role_id == 15)
                                                    <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">ANALISIS:</label>
                                                    <input type="file" class="form-control" name="analisis" id="analisis" {{ (Auth::user()->role_id !== 15) ? 'disabled' : '' }}>
                                                    @if($redb->ruta_analisis)
                                                        <a href="{{ route('verANALISIS', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">MEMORIA:</label>
                                                    <input type="file" class="form-control" name="memoria" id="memoria" {{ (Auth::user()->role_id !== 15) ? 'disabled' : '' }}>
                                                    @if($redb->ruta_memoria)
                                                        <a href="{{ route('verMEMORIA', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">CONTRATO:</label>
                                                    <input type="file" class="form-control" name="contrato" id="contrato" {{ (Auth::user()->role_id !== 15) ? 'disabled' : '' }}>
                                                    @if($redb->ruta_contrato)
                                                        <a href="{{ route('verCONTRATO', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">HABILITACION:</label>
                                                    <input type="file" class="form-control" name="habilitacion" id="habilitacion" {{ (Auth::user()->role_id !== 15) ? 'disabled' : '' }}>
                                                    @if($redb->ruta_habilitacion)
                                                        <a href="{{ route('verHAB', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">PLANO:</label>
                                                    <input type="file" class="form-control" name="plano" id="plano" {{ (Auth::user()->role_id !== 15) ? 'disabled' : '' }}>
                                                    @if($redb->ruta_plano)
                                                        <a href="{{ route('verPLANO', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if($historial)
                                            @if($historial->observaciones !== null)
                                            <div class="row">
                                                <div class="col">
                                                    <label for="detalle">Ultima devolución hecha por {{ $historial->user->usuario }}:</label><br>
                                                    <textarea id="detalle" name="ultimo" rows="4" cols="250" readonly>{{ $historial->observaciones }}</textarea>
                                                    <br>
                                                </div>
                                            </div>   
                                            @endif
                                            <div class="row" style="padding-top: 50px;">
                                                <div class="col">
                                                    @if(Auth::id() != $historial->user_id)
                                                        <label for="detalle">Tu devolución:</label><br>
                                                        <textarea id="detalle" name="observaciones" rows="4" cols="250" value=""></textarea>
                                                    @elseif (Auth::user()->role_id == 15)
                                                        <h1 style="text-align: center; color: red;">EL TRÁMITE SE ESTA EVALUANDO</h1>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                            <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit" name="submit">
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
<!-- Modal -->

<div class="modal fade" id="agregarexp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Iniciar Expediente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
        <form action="{{route('expedientedb')}}" method="post">
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

    $(document).ready(function() {
    // Función para agregar fila dinámica
    $(document).on('click', '.addR', function() {
        var html = '';
        html += '<tr>';
        html += '<td style="width: 200px;"><select class="chosen-select rubro" name="rubro[]"><option value="">Seleccionar una opción</option>@foreach($rubros as $dbrubro)<option value="{{$dbrubro->id}}">{{$dbrubro->rubro}}</option>@endforeach</select></td>';
        html += '<td><select class="chosen-select categoria" name="categoria[]" style="width: 300px;"></select></td>';
        html += '<td style="width: 300px;"><select class="chosen-select actividad" name="actividad[]"><option value="ELABORADOR">Elaborador</option><option value="FRACCIONADOR">Fraccionador</option><option value="DEPOSITO">Depósito</option></select></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td></tr>';
        $('#item_tableR').append(html);
        $('.chosen-select').chosen();
    });

    // Actualizar opciones de categoría cuando cambia el rubro
    $(document).on('change', '.rubro', function(e) {
        var dbrubro_id = $(this).val();
        var selectedCategoria = $(this).closest('tr').find('.categoria');

        loadCategorias(dbrubro_id, selectedCategoria);
    });

    // Carga inicial de categorías
    var firstRubro = $('#item_tableR tbody tr:first .rubro');
    if (firstRubro.length > 0) {
        var dbrubro_id = firstRubro.val();
        var selectedCategoria = firstRubro.closest('tr').find('.categoria');
        loadCategorias(dbrubro_id, selectedCategoria);
    }

    function loadCategorias(dbrubro_id, selectedCategoria) {
        $.get('/demo/public/redb/' + dbrubro_id + '/dbcategorias', function(data) {
            selectedCategoria.empty();
            for (var i = 0; i < data.length; ++i) {
                selectedCategoria.append('<option value="' + data[i].id + '">' + data[i].categoria + '</option>');
            }
            selectedCategoria.trigger('chosen:updated');
        });
    }

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });
});

</script>
@endsection
