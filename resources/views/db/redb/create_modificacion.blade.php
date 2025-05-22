@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.redb.edit_inscripcion', 'title' => __('Sistema DPSA')])
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
                    @if(session('notification'))
                    <div class="alert alert-{{ session('class') }}">
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
                                    <strong class="card-title">Modificando Registro R.E.D.B. {{$redb->establecimiento}}</strong>
                                </div>
                                <div class="card-body">
                                       <!-- Si no está de baja, mostrar el mensaje de inscripción con estilo similar -->
                                       @if (!empty($tramite->dbexp) && !empty($tramite->dbexp->numero))
                                            <div class="alert alert-success">
                                                <strong>EL ESTABLECIMIENTO SE ENCUENTRA INSCRIPTO CON EL NÚMERO DE ESTABLECIMIENTO: {{ $redb->numero }}</strong>
                                            </div>
                                        @endif
                                        <form id="formulario" method="post" action="{{ route('db_redb_store_modificacion', $redb->id) }}" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Establecimiento:</label>
                                                    <input type="text" class="form-control form-control-sm" name="establecimiento" value="{{ $redb->establecimiento }}">
                                                    <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Domicilio:</label>
                                                        <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ $redb->domicilio }}" readonly>
                                                    <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-2">
                                                <div class="form-group">
                                                    <label for="localidad">Localidad:</label><br>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $redb->localidad->localidad }}" readonly>
                                                        <input type="hidden" name="localidad_id" value="{{ $redb->localidad_id }}">
                                                    <small class="form-text text-danger">* La Localidad es requerida.</small>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-2">
                                                <div class="form-group">
                                                    @if(in_array(Auth::user()->role_id, [1, 9, 16, 17, 18]))
                                                        <label for="dbdt">Vinculación DT:</label>
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
                                        @if(in_array(Auth::user()->role_id, [1, 9, 16, 17, 18]))
                                        <div id="rubros">
                                            <table class="table table-bordered" style="margin-bottom: 80px;" id="item_tableR">
                                                <tr>
                                                    <th>Rubro</th>
                                                    <th>Categorías</th>
                                                    <th>Actividades</th>
                                                    <th>
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
                                                    <td><input type="text" name="actividad[]" class="form-control form-control-sm" value="{{ $rubro->pivot->actividad }}"style="display: none;">{{ $rubro->pivot->actividad }}</td>
                                                    <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dni">HABILITACION (PDF):</label>
                                                    <input type="file" class="form-control" name="habilitacion" id="habilitacion">
                                                    <div id="vistaPreviaHab"></div>
                                                    @if($redb->ruta_habilitacion)
                                                        <a href="{{ route('verHAB', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dni">PLANO (PDF):</label>
                                                    <input type="file" class="form-control" name="plano" id="plano">
                                                    <div id="vistaPreviaPlano"></div>
                                                    @if($redb->ruta_plano)
                                                        <a href="{{ route('verPLANO', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dni">MEMORIA DESCRIPTIVA (PDF):</label>
                                                    <input type="file" class="form-control" name="memoria" id="memoria">
                                                    <div id="vistaPreviaMemoria"></div>
                                                    @if($redb->ruta_memoria)
                                                        <a href="{{ route('verMEMORIA', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dni">CONTRATO/TITULO DE PROPIEDAD (PDF):</label>
                                                    <input type="file" class="form-control" name="contrato" id="contrato">
                                                    <div id="vistaPreviaContrato"></div>
                                                    @if($redb->ruta_contrato)
                                                        <a href="{{ route('verCONTRATO', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dni">ANALISIS DE AGUA (PDF):</label>
                                                    <input type="file" class="form-control" name="analisis" id="analisis">
                                                    <div id="vistaPreviaAnalisis"></div>
                                                    @if($redb->ruta_analisis)
                                                        <a href="{{ route('verANALISIS', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <!-- Campo de archivo de pago -->
                                                <div class="form-group">
                                                    <label for="pago">PAGO (PDF):</label>
                                                    <input type="file" class="form-control" name="pago" id="pago">
                                                    <div id="vistaPreviaPago"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="vinculacion">NOTA VINCULACION DT/AT (PDF):</label>
                                                    <input type="file" class="form-control" name="vinculacion" id="vinculacion">
                                                    <div id="vistaPreviaVinculacion"></div>
                                                    @if($redb->ruta_plano)
                                                        <a href="{{ route('verVINCDT', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="nuevaDevolucion">Descripción de la modificación:</label><br>
                                                <textarea id="nuevaDevolucion" name="observaciones" rows="4" cols="250" class="w-100" value=""></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ URL::previous() }}">CANCELAR</a>
                                        @if (Auth::user()->role_id == 15 && ($redb->dbbaja_id === null || $redb->dbbaja_id == 0))
                                            <button type="submit" class="btn btn-warning pull-center button-prevent-multiple-submit" name="submitType" value="modificacion">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                MODIFICACIÓN
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
    var observaciones = document.getElementById('nuevaDevolucion').value;
    var alertaMostrada = false;

    // Verificar si el textarea de observaciones está vacío
    if (observaciones.trim() === '') {
        alert('Por favor, completa el campo de NUEVA DEVOLUCIÓN.');
        alertaMostrada = true;
    }

    if (alertaMostrada) {
        event.preventDefault(); // Evita el envío del formulario si hay errores
        return false;
    }

    return true; // Permite el envío del formulario si no hay errores
}


document.getElementById('dbdt').addEventListener('change', function() {
        var selectedValue = this.value;
        document.querySelector('input[name="dbdt_id_hidden"]').value = selectedValue;
});
</script>
@endsection
