@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.redb.edit', 'title' => __('Sistema DPSA')])
@section('content')
{{ Form::hidden('url', URL::full()) }}
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
                                    <form id="formulario" method="post" action="{{ route('db_redb_update', $redb->id) }}" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                                        {{ csrf_field() }}
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Establecimiento:</label>
                                                <input type="text" class="form-control form-control-sm" name="establecimiento" value="{{ $redb->establecimiento }}">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Domicilio:</label>
                                                <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ $redb->domicilio }}">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="localidad">Localidad:</label><br>
                                                        <select class="chosen-select" name="localidad_id" id="localidad">
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
                                                        <!-- Elimina la condición para mostrar el botón de agregar -->
                                                        <button type="button" name="addR" class="btn btn-success btn-sm addR"><i class="fas fa-plus"></i></button>
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
                                                    <!-- Elimina la condición para mostrar el botón de eliminar -->
                                                    <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">ANALISIS:</label>
                                                    <input type="file" class="form-control" name="analisis" id="analisis">
                                                    <div id="vistaPreviaAnalisis"></div>
                                                    @if($redb->ruta_analisis)
                                                        <a href="{{ route('verANALISIS', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">MEMORIA:</label>
                                                    <input type="file" class="form-control" name="memoria" id="memoria">
                                                    <div id="vistaPreviaMemoria"></div>
                                                    @if($redb->ruta_memoria)
                                                        <a href="{{ route('verMEMORIA', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">CONTRATO:</label>
                                                    <input type="file" class="form-control" name="contrato" id="contrato">
                                                    <div id="vistaPreviaContrato"></div>
                                                    @if($redb->ruta_contrato)
                                                        <a href="{{ route('verCONTRATO', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">HABILITACION:</label>
                                                    <input type="file" class="form-control" name="habilitacion" id="habilitacion">
                                                    <div id="vistaPreviaHab"></div>
                                                    @if($redb->ruta_habilitacion)
                                                        <a href="{{ route('verHAB', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">PLANO:</label>
                                                    <input type="file" class="form-control" name="plano" id="plano">
                                                     <div id="vistaPreviaPlano"></div>
                                                    @if($redb->ruta_plano)
                                                        <a href="{{ route('verPLANO', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="pago">Pago:</label>
                                                    <input type="file" class="form-control" name="pago" id="pago">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                    <div id="vistaPreviaPago"></div>
                                                    @if($redb->ruta_pago)
                                                        <a href="{{ route('verPAGO', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="dni">ACTA INSPECCION:</label>
                                                    <input type="file" class="form-control" name="acta" id="acta" accept=".pdf">
                                                    <div id="vistaPreviaActa"></div>
                                                    @if($redb->ruta_acta)
                                                        <a href="{{ route('verACTA', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                    <small class="form-text text-danger">* Subir archivo del ACTA DE INSPECCION para poder elevar el tramite para su correspondiente "EVALUACIÓN FINAL", NO hacerlo antes.</small>
                                                </div>
                                            </div>
                                        </div>
                                        @if($ultimoHistorial)
                                            <div class="row">
                                                <div class="col">
                                                    <label for="ultimo">Ultima devolución hecha por:</label><br>
                                                    <textarea id="ultimo" name="ultimo" rows="4" cols="250"  class="w-100" readonly>{{ $ultimoHistorial->observaciones }}</textarea>
                                                    <br>
                                                </div>
                                            </div>   
                                        @endif
                                        @if (!empty($redb->expediente))
                                        <div class="row">
                                            <div class="col">
                                            <h1 style="text-align: center; color: red;">EL ESTABLECIMIENTO SE ENCUENTRA INSCRIPTO CON EL NUMERO DE ESTABLECIMINETO: {{$redb->numero}}</h1>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                            <button type="submit" class="btn btn-success pull-center button-prevent-multiple-submit" name="submitType" value="aprobar" id="aprobar">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                ACTUALZAR DATOS
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
    // Llamar a la función validarFormulario() al enviar el formulario
    return validarFormulario();
});

function validarFormulario() {
    var acta = document.getElementById('acta');
    var observaciones = document.getElementById('nuevaDevolucion').value;
    var alertaMostrada = false;

    // Verificar si se está enviando el formulario mediante el botón de EVALUADO
    if (event.submitter && event.submitter.id === 'boton-evaluar') {
        // Verificar si el campo de archivo está vacío
        if (acta.files.length === 0) {
            // Mostrar un mensaje de alerta para el campo de archivo vacío
            alert('Por favor, ADJUNTA EL ACTA DE INSPECCION.');
            // Establecer la variable de control como true
            alertaMostrada = true;
        }
    }

    // Verificar si el textarea está vacío
    if (observaciones.trim() === '') {
        // Mostrar un mensaje de alerta para el campo de observaciones vacío
        alert('Por favor, completa el campo de NUEVA DEVOLUCION.');
        // Establecer la variable de control como true
        alertaMostrada = true;
    }

    // Devolver false si se mostró alguna alerta
    if (alertaMostrada) {
        return false;
    }

    // Devolver true para permitir el envío del formulario si no se mostró ninguna alerta
    return true;
}

</script>
 @endsection
