@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.rpadb.create', 'title' => __('Sistema DPSA')])
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
                                <strong class="card-title">Ingreso Registro</strong>
                            </div>
                            <div class="card-body">
                                <form name="form_check" id="form_check" class="form-prevent-multiple-submit" method="post" action="{{ route('db_rpadb_store_inscripcion') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div id="productos">
                                        <div class="producto-group">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Denominación:</label>
                                                        <input type="text" name="denominacion" class="form-control" required>
                                                        <small class="form-text text-danger">* Requerido.</small>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Nombre Fantasía:</label>
                                                        <input type="text" name="nombre_fantasia" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Marca:</label>
                                                        <input type="text" name="marca" class="form-control" required>
                                                        <small class="form-text text-danger">* Requerido.</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="redb_id">Seleccionar Establecimiento:</label>
                                                    <select class="form-control" name="redb_id" id="redb_id" required>
                                                        <option value="">Seleccione un establecimiento</option>
                                                        @foreach($redbs as $redb)
                                                            <option value="{{ $redb->id }}">
                                                                {{ $redb->numero }} - {{ $redb->establecimiento }} ({{ $redb->domicilio }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                {{-- ENVASES --}}
                                                <div class="col">
                                                    <div id="envases" style="overflow-x: auto;">
                                                        <label class="bmd-label-floating">Envases:</label>
                                                        <table class="table table-bordered table-sm" id="item_tableE" style="width: 100%;">
                                                            <thead class="thead-light">
                                                                <tr class="small">
                                                                    <th class="text-center"></th>
                                                                    <th>
                                                                        Agregar envase ----> 
                                                                        <button type="button" class="btn btn-success btn-sm addE"><i class="fas fa-plus"></i></button>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="envase-group">
                                                                <!-- Filas dinámicas aquí -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                            </div>

                                            <h2 class="text-primary font-weight-bold mt-4 text-center">Documentación Adjunta</h2>
                                            <hr>

                                            <div class="row">
                                                {{-- MONOGRAFÍA --}}
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Monografía e información nutricional:</label>
                                                        <input type="file" name="productos[0][monografia][]" multiple class="form-control-file file-input" accept="application/pdf" data-preview="vistaPreviaMonografia">
                                                        <small class="form-text text-danger">* Requerido.</small>
                                                        <div id="vistaPreviaMonografia" class="mt-2"></div>
                                                    </div>
                                                </div>

                                                {{-- ESPECIFICACIONES --}}
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Especificaciones técnicas:</label>
                                                        <input type="file" name="productos[0][especificaciones][]" multiple class="form-control-file file-input" accept="application/pdf" data-preview="vistaPreviaEspecificaciones">
                                                        <small class="form-text text-danger">* Opcional.</small>
                                                        <div id="vistaPreviaEspecificaciones" class="mt-2"></div>
                                                    </div>
                                                </div>

                                                {{-- ANÁLISIS --}}
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Análisis:</label>
                                                        <input type="file" name="productos[0][analisis][]" multiple class="form-control-file file-input" accept="application/pdf" data-preview="vistaPreviaAnalisis">
                                                        <small class="form-text text-danger">* Opcional.</small>
                                                        <div id="vistaPreviaAnalisis" class="mt-2"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                {{-- COMPROBANTE DE PAGO --}}
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-group">
                                                        <label>Comprobante de pago:</label>
                                                        <input type="file" name="productos[0][pago]" class="form-control file-input" accept="application/pdf" data-preview="vistaPreviaPago" required>
                                                        <small class="form-text text-danger">* Requerido.</small>
                                                        <div id="vistaPreviaPago" class="mt-2"></div>
                                                    </div>
                                                </div>

                                                {{-- ARTÍCULO CAA --}}
                                                <div class="col-md-4 mb-3">
                                                    @if (in_array(Auth::user()->role_id, [9, 16, 17, 18]))
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Artículo del CAA:</label>
                                                            <input type="text" class="form-control" name="articulo_caa" required>
                                                            <small class="form-text text-danger">* Requerido.</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr style="border-top: 3px solid #000; margin-top: 20px; margin-bottom: 20px;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                            <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit" name="submit">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                Ingresar Tramite
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
<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
<script>
$(document).ready(function () {
    // Variable para llevar el conteo de envases
    let envaseNumero = 1;

    // Agregar envase dinámico
    $(document).on('click', '.addE', function () {
        let productoGroup = $(this).closest('.producto-group');
        let productoIndex = productoGroup.index();
        let envaseIndex = productoGroup.find('.envase-group').length;

        let html = '<tbody class="envase-group">';
        html += '<tr><th>#</th><th>Envase Tipo</th><th>Material</th><th>Contenido Neto</th><th>Contenido Escurrido</th><th>Eliminar</th></tr>';
        html += '<tr>';
        html += '<td>' + envaseNumero + '</td>';
        html += '<td><input type="text" class="form-control form-control-sm" name="productos[' + productoIndex + '][envases][' + envaseIndex + '][tipo_envase]" placeholder="Tipo de envase"></td>';
        html += '<td><input type="text" class="form-control form-control-sm" name="productos[' + productoIndex + '][envases][' + envaseIndex + '][material]"></td>';
        html += '<td><input type="text" class="form-control form-control-sm" name="productos[' + productoIndex + '][envases][' + envaseIndex + '][contenido_neto]"></td>';
        html += '<td><input type="text" class="form-control form-control-sm" name="productos[' + productoIndex + '][envases][' + envaseIndex + '][contenido_escurrido]"></td>';
        html += '<td><button type="button" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td>';
        html += '</tr>';
        html += '<tr class="small"><th>#</th><th>Lapso de Aptitud</th><th>Condiciones de Conservación</th><th>Certificado de envase</th><th>Rótulo del envase</th></tr>';
        html += '<tr>';
        html += '<td>' + envaseNumero + '</td>';
        html += '<td><input type="text" class="form-control form-control-sm" name="productos[' + productoIndex + '][envases][' + envaseIndex + '][lapso_aptitud]"></td>';
        html += '<td><input type="text" class="form-control form-control-sm" name="productos[' + productoIndex + '][envases][' + envaseIndex + '][condiciones_conservacion]"></td>';
        html += '<td>';
        html += '<input type="file" class="form-control form-control-sm file-input" name="productos[' + productoIndex + '][envases][' + envaseIndex + '][certificado_envase]" accept="application/pdf" data-preview="vistaPreviaCertificado_' + productoIndex + '_' + envaseIndex + '">';
        html += '<div id="vistaPreviaCertificado_' + productoIndex + '_' + envaseIndex + '" class="mt-2"></div>';
        html += '<button type="button" class="btn btn-danger btn-sm remove-file" data-target="vistaPreviaCertificado_' + productoIndex + '_' + envaseIndex + '"><i class="fas fa-trash"></i> Eliminar</button>';
        html += '</td>';
        html += '<td>';
        html += '<input type="file" class="form-control form-control-sm file-input" name="productos[' + productoIndex + '][envases][' + envaseIndex + '][rotulo_envase]" accept="application/pdf" data-preview="vistaPreviaRotulo_' + productoIndex + '_' + envaseIndex + '">';
        html += '<div id="vistaPreviaRotulo_' + productoIndex + '_' + envaseIndex + '" class="mt-2"></div>';
        html += '<button type="button" class="btn btn-danger btn-sm remove-file" data-target="vistaPreviaRotulo_' + productoIndex + '_' + envaseIndex + '"><i class="fas fa-trash"></i> Eliminar</button>';
        html += '</td>';
        html += '</tr>';

        html += '<tr><td colspan="6"><hr style="border-top: 3px solid #000; margin-top: 20px; margin-bottom: 20px;"></td></tr>';
        html += '</tbody>';

        envaseNumero++;
        productoGroup.find('#item_tableE').append(html);
    });

    // Eliminar envase
    $(document).on('click', '.remove', function () {
        $(this).closest('tbody.envase-group').remove();
    });

    // Función general para vista previa de PDF usando FileReader
    function generarVistaPrevia(input, targetId) {
        const contenedor = document.getElementById(targetId);
        if (!contenedor) return;

        contenedor.innerHTML = '';
        Array.from(input.files).forEach(function (archivo) {
            if (archivo.type === 'application/pdf') {
                const lector = new FileReader();
                lector.onload = function (e) {
                    const embed = document.createElement('embed');
                    embed.src = e.target.result;
                    embed.type = 'application/pdf';
                    embed.width = '100%';
                    embed.height = '300px';
                    embed.style.marginBottom = '10px';
                    contenedor.appendChild(embed);
                };
                lector.readAsDataURL(archivo);
            } else {
                const msg = document.createElement('p');
                msg.textContent = `"${archivo.name}" no es un archivo PDF válido.`;
                msg.classList.add('text-danger');
                contenedor.appendChild(msg);
            }
        });
    }

    // Vista previa dinámica para todos los inputs con class="file-input"
    $(document).on('change', '.file-input', function () {
        const targetId = $(this).data('preview');
        if (targetId) {
            generarVistaPrevia(this, targetId);
        }
    });

    // === Vista previa estática para campos ya definidos (por ID) ===

    // MONOGRAFÍA
    const monografiaInput = document.querySelector('[name="productos[0][monografia][]"]');
    if (monografiaInput) {
        monografiaInput.classList.add('file-input');
        monografiaInput.setAttribute('data-preview', 'vistaPreviaMonografia');
    }

    // ESPECIFICACIONES
    const especificacionesInput = document.querySelector('[name="productos[0][especificaciones][]"]');
    if (especificacionesInput) {
        especificacionesInput.classList.add('file-input');
        especificacionesInput.setAttribute('data-preview', 'vistaPreviaEspecificaciones');
    }

    // ANÁLISIS
    const analisisInput = document.querySelector('[name="productos[0][analisis][]"]');
    if (analisisInput) {
        analisisInput.classList.add('file-input');
        analisisInput.setAttribute('data-preview', 'vistaPreviaAnalisis');
    }

    // PAGO
    const pagoInput = document.querySelector('[name="productos[0][pago]"]');
    if (pagoInput) {
        pagoInput.classList.add('file-input');
        pagoInput.setAttribute('data-preview', 'vistaPreviaPago');
    }

    // Eliminar archivo cargado
    $(document).on('click', '.remove-file', function () {
        const targetId = $(this).data('target');
        const contenedor = document.getElementById(targetId);
        if (contenedor) {
            contenedor.innerHTML = ''; // Elimina la vista previa
            // Resetea el input file (no funciona en todos los navegadores por seguridad)
            const input = $(this).closest('td').find('input[type="file"]');
            input.val('');
        }
    });
});
</script>
