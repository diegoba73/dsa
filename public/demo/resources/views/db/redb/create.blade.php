@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.redb.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Inicio tramite de Inscripción de Establecimiento Elaborador Provincial</strong>
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
                                    <form name="form_check" id="form_check" class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/redb/') }}" enctype="multipart/form-data"> 
                                    {{ csrf_field() }}
                                    <div class="row">

                                        </div>
                                        @foreach($dbempresa as $empresa)
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Empresa:</label>
                                                <input type="text" class="form-control form-control-sm" value="{{ $empresa->empresa }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Domicilio:</label>
                                                <input type="text" class="form-control form-control-sm" value="{{ $empresa->domicilio }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Ciudad:</label>
                                                <input type="text" class="form-control form-control-sm" value="{{ $empresa->ciudad }}" readonly>
                                                </div>
                                            </div>  
                                            <div class="col-1">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Provincia:</label>
                                                <input type="text" class="form-control form-control-sm" value="{{ $empresa->provincia }}" readonly>
                                                </div>
                                            </div> 
                                        </div>  
                                        @endforeach
                                        <hr>
                                        <h3>Datos del Establecimiento</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Razón:</label>
                                                <input type="text" class="form-control form-control-sm" name="razon">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Domicilio:</label>
                                                <input type="text" class="form-control form-control-sm" name="domicilio">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="localidad">Localidad:</label><br>
                                                    <select class="chosen-select" name="localidad_id" id="localidad">
                                                        <option disabled selected>Seleccionar Localidad</option>
                                                        @foreach($localidads as $localidad)
                                                        <option value="{{$localidad->id}}">{{$localidad->localidad}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-danger">* La localidad es requerida.</small>
                                                </div>
                                            </div>   
                                            <div class="col-2">
                                                <div class="form-group">
                                                        <label class="label-control">Fecha de Inscripción:</label>
                                                        <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_inscripcion" value="<?php echo date('Y-m-d'); ?>">
                                                        <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>  
                                        </div>    
                                        <div id="rubros">
                                        <table class="table table-bordered" style="margin-bottom: 80px;" id="item_tableR">
                                            <tr>
                                            <th>Rubro</th>
                                            <th>Categorias</th>
                                            <th>Actividades</th>
                                            <th><button type="button" name="addR" class="btn btn-success btn-sm addR"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                        </table>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="contrato">Análisis:</label>
                                                    <input type="file" class="form-control" name="analisis" id="analisis">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="contrato">Memoria descriptiva:</label>
                                                    <input type="file" class="form-control" name="memoria" id="memoria">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="contrato">Contrato:</label>
                                                    <input type="file" class="form-control" name="contrato" id="contrato">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="habilitacion">Habilitación:</label>
                                                    <input type="file" class="form-control" name="habilitacion" id="habilitacion">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="plano">Plano:</label>
                                                    <input type="file" class="form-control" name="plano" id="plano">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ route('db_redb_index') }}">Cancelar</a>          
                                        <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    Iniciar
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

<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>

<script>
$(document).ready(function() {
    // Función para agregar fila dinámica
    $(document).on('click', '.addR', function() {
        var html = '';
        html += '<tr>';
        html += '<td style="width: 200px;"><select class="chosen-select rubro" name="rubro[]"><option value="">Seleccionar una opción</option>@foreach($dbrubros as $dbrubro)<option value="{{$dbrubro->id}}">{{$dbrubro->rubro}}</option>@endforeach</select></td>';
        html += '<td style="width: 300px;"><select class="chosen-select categoria" name="categoria[]" style="width: 300px;"></select></td>';
        html += '<td style="width: 100px;"><select class="chosen-select actividad" name="actividad[]"><option value="ELABORADOR">Elaborador</option><option value="FRACCIONADOR">Fraccionador</option><option value="DEPOSITO">Depósito</option></select></td>';
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