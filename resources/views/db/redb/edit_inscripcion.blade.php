@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.redb.edit_inscripcion', 'title' => __('Sistema DPSA')])
@section('content')
{{ Form::hidden('url', URL::full()) }}
@php
    // Verifica si el usuario tiene un role_id que debe bloquear los campos
    $bloquearCampos = in_array(Auth::user()->role_id, [9, 16, 17, 18]);
@endphp
<div class="header bg-primary pb-8 pt-5 pt-md-6">
        <div class="container-fluid">
  
                <div class="card-body">
                    @if(isset($notification) && $notification != '')
                        <div class="alert alert-info" role="alert">
                            {!! $notification !!}
                        </div>
                    @endif
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
                                    <strong class="card-title">Actualizando Registro R.E.D.B. {{$redb->establecimiento}}</strong>
                                </div>
                                <div class="card-body">
                                    <div class="banner-estado-tramite">
                                        <h2 id="estado-tramite-text"></h2>
                                    </div>
                                    <form id="formulario" method="post" action="{{ route('db_redb_update_inscripcion', $redb->id) }}" enctype="multipart/form-data" onsubmit="return validarFormulario(event)">
                                        {{ csrf_field() }}
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Establecimiento:</label>
                                                    <input type="text" class="form-control form-control-sm" name="establecimiento" value="{{ $redb->establecimiento }}" {{ ((Auth::user()->role_id != 15) || ((Auth::user()->role_id == 15) && $historial && $historial->user && (Auth::id() == $historial->user_id))) ? 'readonly' : '' }}>
                                                    <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Domicilio:</label>
                                                    <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ $redb->domicilio }}" {{ ((Auth::user()->role_id != 15) || ((Auth::user()->role_id == 15) && $historial && $historial->user && (Auth::id() == $historial->user_id))) ? 'readonly' : '' }}>
                                                    <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-2">
                                                <div class="form-group">
                                                    <label for="localidad">Localidad:</label><br>
                                                    <select class="chosen-select form-control" name="localidad_id" id="localidad" {{ ((Auth::user()->role_id != 15) || ((Auth::user()->role_id == 15) && $historial && $historial->user && (Auth::id() == $historial->user_id))) ? 'disabled' : '' }}>
                                                        <option disabled selected>Seleccionar Localidad</option>
                                                        @foreach($localidads as $localidad)
                                                        <option value="{{$localidad->id}}" @if(($redb->localidad_id) == ($localidad->id)) selected="selected" @endif>{{$localidad->localidad}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="localidad_id_hidden" value="{{ $redb->localidad_id }}">
                                                    <small class="form-text text-danger">* La Localidad es requerida.</small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-2">
                                                <div class="form-group">
                                                    <label for="dbdt">Vinculación DT:</label>
                                                    @if(in_array(Auth::user()->role_id, [1, 9, 16, 17, 18]))
                                                        <select class="chosen-select form-control" name="dbdt_id" id="dbdt">
                                                            <option disabled selected>Seleccionar Vinculación DT</option>
                                                            @foreach($dbdts as $dbdt)
                                                                <option value="{{ $dbdt->id }}" @if($redb->dbdt_id == $dbdt->id) selected="selected" @endif>
                                                                    {{ $dbdt->nombre }} - {{ $dbdt->matricula }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <input type="hidden" name="dbdt_id" value="{{ $redb->dbdt_id }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Campos adicionales de la tabla, como rubros, categorías y actividades -->
                                        <div id="rubros">
                                            <table class="table table-bordered" style="margin-bottom: 80px;" id="item_tableR">
                                                <tr>
                                                    <th>Rubro</th>
                                                    <th>Categorías</th>
                                                    <th>Actividades</th>
                                                    <th>
                                                        @if(in_array(Auth::user()->role_id, [1, 9, 16, 17, 18]))
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
                                                    <td><input type="text" name="actividad[]" class="form-control form-control-sm" value="{{ $rubro->pivot->actividad }}" style="display: none;">{{ $rubro->pivot->actividad }}</td>
                                                    @if(in_array(Auth::user()->role_id, [1, 9, 16, 17, 18]))
                                                    <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dni">ANALISIS DE AGUA (PDF):</label>
                                                    <input type="file" class="form-control" name="analisis" id="analisis" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                    <div id="vistaPreviaAnalisis"></div>
                                                    @if($redb->ruta_analisis)
                                                        <a href="{{ route('verANALISIS', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dni">MEMORIA DESCRIPTIVA (PDF):</label>
                                                    <input type="file" class="form-control" name="memoria" id="memoria" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                    <div id="vistaPreviaMemoria"></div>
                                                    @if($redb->ruta_memoria)
                                                        <a href="{{ route('verMEMORIA', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dni">CONTRATO/TITULO DE PROPIEDAD (PDF):</label>
                                                    <input type="file" class="form-control" name="contrato" id="contrato" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                    <div id="vistaPreviaContrato"></div>
                                                    @if($redb->ruta_contrato)
                                                        <a href="{{ route('verCONTRATO', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dni">HABILITACION (PDF):</label>
                                                    <input type="file" class="form-control" name="habilitacion" id="habilitacion" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                    <div id="vistaPreviaHab"></div>
                                                    @if($redb->ruta_habilitacion)
                                                        <a href="{{ route('verHAB', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dni">PLANO (PDF):</label>
                                                    <input type="file" class="form-control" name="plano" id="plano" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                    <div id="vistaPreviaPlano"></div>
                                                    @if($redb->ruta_plano)
                                                        <a href="{{ route('verPLANO', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="pago">PAGO (PDF):</label>
                                                    <input type="file" class="form-control" name="pago" id="pago" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                    <div id="vistaPreviaPago"></div>
                                                    @if($redb->ruta_pago)
                                                        <a href="{{ route('verPAGO_redb', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- //PAGO -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="vinculacion">NOTA VINCULACION DT/AT (PDF):</label>
                                                    <input type="file" class="form-control" name="vinculacion" id="vinculacion" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                    <div id="vistaPreviaVinculacion"></div>
                                                    @if($redb->ruta_plano)
                                                        <a href="{{ route('verVINCDT', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if(in_array(Auth::user()->role_id, [1, 9, 16, 17, 18]))
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="dni">ACTA INSPECCIÓN:</label>
                                                    <input type="file" class="form-control" name="acta" id="acta" accept=".pdf">
                                                    <div id="vistaPreviaActa"></div>
                                                    @if($redb->ruta_acta)
                                                        <a href="{{ route('verACTA', $redb->id) }}" target="_blank" id="enlace-acta">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                    <small class="form-text text-danger">* Subir archivo del ACTA DE INSPECCIÓN para poder elevar el trámite para su correspondiente "EVALUACIÓN FINAL", NO hacerlo antes.</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <!-- Agregar campo comentarios -->
                                        @if($ultimoHistorial)
                                            <div class="row">
                                                <div class="col">
                                                    <label for="ultimo">Ultima devolución hecha por {{ $ultimoHistorial->user->usuario }}:</label><br>
                                                    <textarea id="ultimo" name="ultimo" rows="4" cols="250" class="w-100" readonly>{{ $ultimoHistorial->observaciones }}</textarea>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                <div class="form-group">
                                                @if (Auth::id() != $historial->user_id)
                                                    <label for="nuevaDevolucion">Nueva devolución:</label><br>
                                                    <textarea id="nuevaDevolucion" name="observaciones" rows="4" cols="250" class="w-100">{{ old('observaciones') }}</textarea>
                                                @endif
                                                </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ((Auth::user()->role_id === 1) 
                                            && ($tramite->estado === 'APROBADO' ))
                                            <div class="row align-items-center p-1">
                                                <div class="col-xs-6">
                                                    <label class="bmd-label-floating">Expediente:</label>
                                                    <input type="text" class="form-control form-control-sm" name="expediente" value="{{ $tramite->dbexp->numero ?? '' }}" {{ (Auth::user()->role_id != 1) ? 'readonly' : '' }}>
                                                    <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                                <div class="col-xs-2 p-1">
                                                <a href="#agregarexp" data-toggle="modal" title="Nº Expediente" class="btn btn-sm btn-success btn-close m-2">Nº Expediente</a>
                                                </div>
                                            </div>
                                        @endif
                                        <!-- Banners y botones -->
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                            @if (Str::contains($tramite->tipo_tramite, 'BAJA'))
                                                @if($redb->dbbaja_id !== null && $redb->dbbaja_id != 0)
                                                    <!-- Banner de establecimiento de baja -->
                                                    <div class="alert alert-danger">
                                                        <strong>EL ESTABLECIMIENTO SE ENCUENTRA DE BAJA</strong>
                                                    </div>
                                                @else
                                                    <!-- Mensaje de solicitud de baja -->
                                                    <div class="alert alert-danger">
                                                        <strong>SE SOLICITO LA BAJA DEL ESTABLECIMIENTO</strong>
                                                    </div>
                                                @endif
                                            @endif
                                            @if ($redb->dbtramites->contains('estado', 'APROBADO'))
                                                <div class="alert alert-success">
                                                    <strong>EL TRAMITE DE INSCRIPCIÓN SE APROBÓ.</strong>
                                                </div>
                                            @endif
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <!-- Botón de Cancelar -->
                                                <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                                <!-- Enviar Modificación (solo para rol PRODUCTOR con estado distinto a INICIADO) -->
                                                @if (Auth::user()->role_id == 15 && !in_array($tramite->estado, ['INICIADO', 'REENVIADO POR EMPRESA', 'APROBADO', 'DEVUELTO A NC']) && $tramite->finalizado == 0)
                                                    <button type="submit" id="boton-enviar" class="btn btn-success pull-center button-prevent-multiple-submit" name="submitType" value="reenvio_empresa">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        ENVIAR MODIFICACIÓN
                                                    </button>
                                                @endif
                                                @if (
                                                    ((Auth::user()->role_id !== 15) && (Auth::user()->role_id !== 1))
                                                    && in_array($tramite->estado, ['INICIADO', 'REENVIADO POR EMPRESA', 'DEVUELTO A NC', 'DEVUELTO A AREA PROGRAMATICA'])
                                                    && Str::contains(strtoupper($tramite->tipo_tramite), 'REINSCRIPCION') === false
                                                    && !(Auth::user()->role_id === 9 && $tramite->estado === 'INICIADO' && optional($tramite->dbredb->localidad)->zona !== 'nc')
                                                    && !($tramite->area === 'AREA PROGRAMATICA' && Auth::user()->role_id === 9) // Ocultar si rol 9 y está en AREA PROGRAMATICA
                                                )
                                                    <button type="submit" class="btn btn-danger" name="submitType" value="devolver">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        Devolver a Empresa
                                                    </button>
                                                @endif
                                                <!-- Para roles de ÁREAS (16, 17, 18) cuando el trámite es de zona "apcr", "ape", "appm" y no está DEVUELTO A EMPRESA -->
                                                @if (
                                                    in_array(Auth::user()->role_id, [16, 17, 18]) 
                                                    && in_array($redb->localidad->zona, ['apcr', 'ape', 'appm'])
                                                )
                                                    @if (
                                                        $tramite->estado !== 'OBSERVADO POR AUTORIDAD SANITARIA'
                                                        && $tramite->estado !== 'EVALUADO POR AREA PROGRAMATICA'
                                                    )
                                                        <button type="submit" id= "aceptar_area" class="btn btn-success" name="submitType" value="aceptar_area">
                                                            <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                            Aceptar y Enviar a NC
                                                        </button>
                                                    @endif
                                                @endif
                                                <!-- Para usuario DB (rol 9) cuando el trámite es de otra zona, en estado ENVIADO A NC y no DEVUELTO A AREA PROGRAMATICA -->
                                                @if ((Auth::user()->role_id == 9) && ($redb->localidad->zona !== 'nc') && ($tramite->estado === 'ENVIADO A NC' || $tramite->estado === 'EVALUADO POR AREA PROGRAMATICA'))
                                                    <button type="submit" class="btn btn-danger" name="submitType" value="devolver">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        Devolver al Área
                                                    </button>
                                                @endif
                                                <!-- Opciones para usuario DB (rol 9) para Aceptar Modificación si el trámite no ha sido devuelto -->
                                                @if (
                                                    (Auth::user()->role_id === 9) 
                                                    && !in_array($tramite->estado, ['APROBADO', 'DEVUELTO A AREA PROGRAMATICA', 'DEVUELTO A EMPRESA', 'OBSERVADO POR AUTORIDAD SANITARIA'])
                                                    && Str::contains(strtoupper($tramite->tipo_tramite), 'REINSCRIPCION') === false
                                                    && !($tramite->estado === 'INICIADO' && optional($tramite->dbredb->localidad)->zona !== 'nc')
                                                    && $tramite->area !== 'AREA PROGRAMATICA' // Ocultar si rol 9 y está en AREA PROGRAMATICA
                                                )
                                                    <button type="submit" id="aprobar" class="btn btn-success pull-center button-prevent-multiple-submit" name="submitType" value="aprobar">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        APROBAR TRAMITE
                                                    </button>
                                                @endif
                                                <!-- Devolver a NC  -->
                                                @if ((Auth::user()->role_id === 1) 
                                                    && ($tramite->estado === 'APROBADO' ))
                                                    <button type="submit" id="boton-aceptar" class="btn btn-danger pull-center button-prevent-multiple-submit" name="submitType" value="devolver">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        Devolver a NC
                                                    </button>
                                                @endif
                                                <!-- Inscribir  -->
                                                @if ((Auth::user()->role_id === 1) 
                                                    && ($tramite->estado === 'APROBADO' ))
                                                    <button type="submit" id="inscribir" class="btn btn-success pull-center button-prevent-multiple-submit" name="submitType" value="inscribir">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        INSCRIBIR
                                                    </button>
                                                @endif
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
        $.get('/redb/' + dbrubro_id + '/dbcategorias', function(data) {
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

        // vista previa analisis
        document.getElementById('analisis').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaAnalisis').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
        });

        // vista previa memoria
        document.getElementById('memoria').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaMemoria').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

        // vista previa contrato
        document.getElementById('contrato').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaContrato').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

            // vista previa habilitacion
        document.getElementById('habilitacion').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaHab').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

        // vista previa plano
        document.getElementById('plano').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaPlano').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

            // vista previa vinculacion
            document.getElementById('vinculacion').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaVinculacion').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

            // vista previa pago
            document.getElementById('pago').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaPago').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

        // vista previa acta
        document.getElementById('acta').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaActa').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

    $(document).ready(function() {
        // Guardar el valor seleccionado
        var localidadValue = $("#localidad").val();

        // Deshabilitar el campo
        $("#localidad").prop("disabled", true);

        // Restaurar el valor seleccionado después de deshabilitar el campo
        $("#localidad").val(localidadValue);
    });


});

document.getElementById('formulario').addEventListener('submit', function(event) {
    // Llamar a la función validarFormulario() y evitar el envío si la validación falla
    if (!validarFormulario(event)) {
        event.preventDefault(); // Evitar el envío del formulario si la validación falla
    }
});

function validarFormulario(event) {
    const acta = document.getElementById('acta');
    const observaciones = document.getElementById('nuevaDevolucion') ? document.getElementById('nuevaDevolucion').value : '';
    const expediente = document.querySelector('input[name="expediente"]');
    const enlaceActa = document.getElementById('enlace-acta'); 
    let mensajesAlerta = [];

    // Verificar si se está enviando el formulario mediante el botón de INSCRIBIR
    if (event.submitter && event.submitter.id === 'inscribir') {
        if (expediente.value.trim() === '') {
            mensajesAlerta.push('Por favor, completa el campo de NÚMERO DE EXPEDIENTE.');
        }
    }

    // Verificar si se está enviando el formulario mediante el botón de APROBAR
    const botonesValidar = ['aprobar', 'aceptar_area'];

    if (event.submitter && botonesValidar.includes(event.submitter.id)) {
        // Validar la existencia del archivo 'acta' o del enlace al acta
        if (!acta.files.length && !enlaceActa.innerHTML) {
            mensajesAlerta.push('Por favor, adjunta el ACTA DE INSPECCIÓN.');
        }
    }

    // Verificar si el textarea de observaciones está vacío
    if (observaciones.trim() === '') {
        mensajesAlerta.push('Por favor, completa el campo de NUEVA DEVOLUCIÓN.');
    }

    // Mostrar todas las alertas juntas si hay errores y detener el envío
    if (mensajesAlerta.length > 0) {
        alert(mensajesAlerta.join('\n'));
        event.preventDefault(); 
        return false; 
    }

    return true; 
}


document.addEventListener('DOMContentLoaded', function() {
    var estadoTramiteText = document.getElementById('estado-tramite-text');
    var estadoActual = "{{ $tramite->area }}"; // Obtén el estado actual desde tu backend

    // Cambia el texto y los estilos según el estado del trámite
    switch (estadoActual) {
        case 'EMPRESA':
            estadoTramiteText.innerHTML = 'El trámite está en EMPRESA';
            estadoTramiteText.parentElement.classList.add('banner-empresa');
            break;
        case 'AREA PROGRAMATICA':
            estadoTramiteText.innerHTML = 'El trámite está en ÁREA PROGRAMÁTICA';
            estadoTramiteText.parentElement.classList.add('banner-area');
            break;
        case 'NIVEL CENTRAL':
            estadoTramiteText.innerHTML = 'El trámite está en NIVEL CENTRAL';
            estadoTramiteText.parentElement.classList.add('banner-nivel-central');
            break;
        case 'JEFATURA':
            estadoTramiteText.innerHTML = 'El trámite está en JEFATURA';
            estadoTramiteText.parentElement.classList.add('banner-jefatura');
            break;
        case 'REGISTRO':
            estadoTramiteText.innerHTML = 'El trámite está finalizado y en el REGISTRO del Departamento Provincial de Bromatología';
            estadoTramiteText.parentElement.classList.add('banner-empresa');
            break;
        default:
            estadoTramiteText.innerHTML = 'Estado del trámite desconocido';
            break;
    }
});

document.getElementById('dbdt').addEventListener('change', function() {
        var selectedValue = this.value;
        document.querySelector('input[name="dbdt_id_hidden"]').value = selectedValue;
});
</script>
@endsection
