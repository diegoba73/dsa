@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.redb.edit_inscripcion', 'title' => __('Sistema DPSA')])
@section('content')
{{ Form::hidden('url', URL::full()) }}
@php
    // Verifica si el usuario tiene un role_id que debe bloquear los campos
    $bloquearCampos = in_array(Auth::user()->role_id, [9, 16, 17, 18]);
    $tramite = $redb->dbtramites->sortByDesc('created_at')->first();
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
                                <strong class="card-title">Actualizando Registro R.E.D.B. Nro: {{$redb->numero}} - {{$redb->establecimiento}}</strong>
                            </div>
                            <div class="card-body">
                                <form id="formulario" method="post" action="{{ route('db_redb_update_modificacion', $redb->id) }}" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Establecimiento:</label>
                                                <input type="text" class="form-control form-control-sm" name="establecimiento" value="{{ $redb->establecimiento }}" {{ $bloquearCampos ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">* Requerido.</small>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Domicilio:</label>
                                                <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ $redb->domicilio }}" {{ $bloquearCampos ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">* Requerido.</small>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="localidad">Localidad:</label><br>
                                                <select class="chosen-select" name="localidad_id" id="localidad" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                    <option disabled selected>Seleccionar Localidad</option>
                                                    @foreach($localidads as $localidad)
                                                        <option value="{{$localidad->id}}" @if(($redb->localidad_id) == ($localidad->id)) selected="selected" @endif>{{$localidad->localidad}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="localidad_id_hidden" value="{{ $redb->localidad_id }}">
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
                                                    @if(!$bloquearCampos)
                                                    <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>

                                    <!-- Campos de subida de archivos -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="analisis">ANALISIS DE AGUA (PDF):</label>
                                                <input type="file" class="form-control" name="analisis" id="analisis" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                <div id="vistaPreviaAnalisis"></div>
                                                @if($redb->ruta_analisis)
                                                    <a href="{{ route('verANALISIS', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="memoria">MEMORIA DESCRIPTIVA (PDF):</label>
                                                <input type="file" class="form-control" name="memoria" id="memoria" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                <div id="vistaPreviaMemoria"></div>
                                                @if($redb->ruta_memoria)
                                                    <a href="{{ route('verMEMORIA', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="contrato">CONTRATO/TITULO DE PROPIEDAD (PDF):</label>
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
                                                <label for="habilitacion">HABILITACION (PDF):</label>
                                                <input type="file" class="form-control" name="habilitacion" id="habilitacion" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                <div id="vistaPreviaHab"></div>
                                                @if($redb->ruta_habilitacion)
                                                    <a href="{{ route('verHAB', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="plano">PLANO (PDF):</label>
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
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="vinculacion">NOTA VINCULACION DT/AT (PDF):</label>
                                                <input type="file" class="form-control" name="vinculacion" id="vinculacion" {{ $bloquearCampos ? 'disabled' : '' }}>
                                                <div id="vistaPreviaVinculacion"></div>
                                                @if($redb->ruta_vinculacion)
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
                                            @if (Auth::id() != $historial->user_id)
                                            @if (($tramite && $tramite->estado !== 'APROBADO')
                                                && !($tramite->estado === 'INICIADO' && $tramite->dbredb->localidad->zona !== 'nc' && Auth::user()->role_id === 9))
                                                <label for="nuevaDevolucion">Nueva devolución:</label><br>
                                                <textarea id="nuevaDevolucion" name="observaciones" rows="4" cols="250" class="w-100">{{ old('observaciones') }}</textarea>
                                                @endif
                                            @endif
                                            </div>
                                        </div>
                                    @endif
                                    @if (Auth::user()->role_id === 1) 
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
                                        @if($redb->dbbaja_id !== null && $redb->dbbaja_id != 0)
                                            <!-- Banner de establecimiento de baja -->
                                            <div class="alert alert-danger">
                                                <strong>EL ESTABLECIMIENTO SE ENCUENTRA DADO DE BAJA</strong>
                                            </div>
                                        @elseif(isset($tramite) && Str::contains(strtoupper($tramite->tipo_tramite), 'MODIFICACION'))
                                            @if($tramite->estado === 'MODIFICADO')
                                                <!-- Mensaje para modificación aprobada por el jefe -->
                                                <div class="alert alert-success">
                                                    <strong>LA MODIFICACIÓN DEL ESTABLECIMIENTO HA SIDO APROBADA</strong>
                                                </div>
                                            @elseif($tramite->estado === 'APROBADO')
                                                <!-- Mensaje para modificación cargada por los inspectores -->
                                                <div class="alert alert-info">
                                                    <strong>LA INFORMACIÓN DE LA MODIFICACIÓN HA SIDO CARGADA POR NIVEL CENTRAL, A LA ESPERA DE SU FINALIZACIÓN</strong>
                                                </div>
                                            @else
                                                <!-- Mensaje para modificación en proceso -->
                                                <div class="alert alert-warning">
                                                    <strong>EL PROCESO DE MODIFICACIÓN DE LA INFORMACIÓN DEL ESTABLECIMIENTO ESTÁ EN CURSO</strong>
                                                </div>
                                            @endif
                                        @else
                                            <!-- Mensaje para estado general sin modificaciones ni bajas -->
                                            <div class="alert alert-info">
                                                <strong>EL ESTABLECIMIENTO ESTÁ INSCRIPTO SIN MODIFICACIONES PENDIENTES</strong>
                                            </div>
                                        @endif
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <!-- Botón de Cancelar -->
                                            <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>

                                            <!-- Botón DAR DE BAJA (si el tipo de trámite es BAJA y no está ya dado de baja) -->
                                            @if (in_array(Auth::user()->role_id, [1, 9]) && Str::contains($tramite->tipo_tramite, 'BAJA ESTABLECIMIENTO') && ($redb->dbbaja_id === null || $redb->dbbaja_id == 0))
                                                <a href="{{ route('db_redb_create_baja', ['redb_id' => $tramite->dbredb_id]) }}" class="btn btn-danger pull-center button-prevent-multiple-submit" title="Baja" rel="tooltip">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    DAR DE BAJA
                                                </a>
                                            @else
                                                <!-- Enviar Modificación (solo para rol PRODUCTOR con estado distinto a INICIADO) -->
                                                @if (Auth::user()->role_id == 15 && !in_array($tramite->estado, ['INICIADO', 'REENVIADO POR EMPRESA', 'APROBADO']))
                                                    <button type="submit" id="boton-enviar" class="btn btn-success pull-center button-prevent-multiple-submit" name="submitType" value="modifica_empresa">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        ENVIAR MODIFICACIÓN
                                                    </button>
                                                @endif

                                                @if (Auth::user()->role_id !== 15 
                                                    && in_array($tramite->estado, ['INICIADO', 'REENVIADO POR EMPRESA']) 
                                                    && !($tramite->estado === 'INICIADO' && $tramite->dbredb->localidad->zona !== 'nc' && Auth::user()->role_id === 9))
                                                    <button type="submit" class="btn btn-danger" name="submitType" value="devolver_empresa">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        Devolver a Empresa
                                                    </button>
                                                @endif
                                                <!-- Botones de devolución y aceptación en los estados apropiados -->

                                                <!-- Para roles de ÁREAS (16, 17, 18) cuando el trámite es de zona "apcr", "ape", "appm" y no está DEVUELTO A EMPRESA -->
                                                @if (in_array(Auth::user()->role_id, [16, 17, 18]) 
                                                    && ($tramite->estado !== 'DEVUELTO A AREA PROGRAMATICA' && $tramite->estado !== 'ENVIADO A NC'))
                                                        <button type="submit" class="btn btn-success" name="submitType" value="enviar_nc">
                                                            <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                            Aceptar y Enviar a NC
                                                        </button>
                                                @endif

                                                <!-- Para usuario DB (rol 9) cuando el trámite es de zona "nc", en estado de REINSCRIPCIÓN, y no está DEVUELTO A EMPRESA -->
                                                @if (Auth::user()->role_id == 9 && $redb->localidad->zona == 'nc' && Str::contains($tramite->tipo_tramite, 'REINSCRIPCION') && $tramite->estado !== 'DEVUELTO A EMPRESA' && Str::contains(strtoupper($tramite->tipo_tramite), 'REINSCRIPCION') === false)
                                                    <button type="submit" class="btn btn-danger" name="submitType" value="devolver_empresa">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        Devolver a Empresa
                                                    </button>
                                                @endif

                                                <!-- Para usuario DB (rol 9) cuando el trámite es de otra zona, en estado ENVIADO A NC y no DEVUELTO A AREA PROGRAMATICA -->
                                                @if (Auth::user()->role_id == 9 && $redb->localidad->zona !== 'nc' && $tramite->estado === 'ENVIADO A NC')
                                                    <button type="submit" class="btn btn-danger" name="submitType" value="devolver_area">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        Devolver al Área
                                                    </button>
                                                @endif

                                                <!-- Opciones para usuario DB (rol 9) y ADMIN (rol 1) para Aceptar Modificación si el trámite no ha sido devuelto -->
                                                @if (
                                                    in_array(Auth::user()->role_id, [1, 9]) 
                                                    && $tramite->estado !== 'APROBADO' 
                                                    && $tramite->estado !== 'DEVUELTO A AREA PROGRAMATICA' 
                                                    && $tramite->estado !== 'DEVUELTO A EMPRESA'
                                                    && $tramite->estado !== 'DEVUELTO' 
                                                    && Str::contains(strtoupper($tramite->tipo_tramite), 'MODIFICACION') === true
                                                    && (!($redb->localidad->zona !== 'nc' && $tramite->estado === 'INICIADO') || $tramite->estado === 'ENVIADO A NC')
                                                )
                                                    <button type="submit" id="boton-aceptar" class="btn btn-success pull-center button-prevent-multiple-submit" name="submitType" value="aprobar">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        ACEPTAR MODIFICACIÓN
                                                    </button>
                                                @endif
                                                <!-- Opciones para usuario DB ADMIN (rol 1) para efectuar modificacion -->
                                                @if (Auth::user()->role_id === 1 && $tramite->estado === 'APROBADO' &&
                                                    Str::contains(strtoupper($tramite->tipo_tramite), 'MODIFICACION'))
                                                    <button type="submit" id="boton-aceptar" class="btn btn-success pull-center button-prevent-multiple-submit" name="submitType" value="modificar">
                                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                        MODIFICAR
                                                    </button>
                                                @endif
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
                        <label class="control-label col-sm-6" for="fecha">Fecha</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control form-control-sm" name="fecha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="descripcion">Descripción</label>
                        <div class="col-sm-6">
                            <input type="name" class="form-control form-control-sm" name="descripcion">
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
                alert('Por favor, seleccione un archivo PDF.');
                event.target.value = '';
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
                alert('Por favor, seleccione un archivo PDF.');
                event.target.value = '';
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
                alert('Por favor, seleccione un archivo PDF.');
                event.target.value = '';
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
                alert('Por favor, seleccione un archivo PDF.');
                event.target.value = '';
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
                alert('Por favor, seleccione un archivo PDF.');
                event.target.value = '';
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
                alert('Por favor, seleccione un archivo PDF.');
                event.target.value = '';
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
                alert('Por favor, seleccione un archivo PDF.');
                event.target.value = '';
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
                alert('Por favor, seleccione un archivo PDF.');
                event.target.value = '';
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

        document.getElementById('formulario').addEventListener('submit', function(event) {
            return validarFormulario();
        });

        function validarFormulario() {
            var acta = document.getElementById('acta');
            var observaciones = document.getElementById('nuevaDevolucion').value;
            var alertaMostrada = false;

            // Verificar si se está enviando el formulario mediante el botón de EVALUADO
            if (event.submitter && event.submitter.id === 'aprobar') {
                // Verificar si el campo de archivo está vacío
                if (acta.files.length === 0) {
                    alert('Por favor, ADJUNTA EL ACTA DE INSPECCION.');
                    alertaMostrada = true;
                }
            }

            // Verificar si el textarea está vacío
            if (observaciones.trim() === '') {
                alert('Por favor, completa el campo de NUEVA DEVOLUCION.');
                alertaMostrada = true;
            }

            if (alertaMostrada) {
                return false;
            }

            return true;
        }
    });
</script>
@endsection
