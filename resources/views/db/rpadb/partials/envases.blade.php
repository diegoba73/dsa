<div id="envases" style="overflow-x: auto;">
    <label class="bmd-label-floating">Envases:</label>
    <table class="table table-bordered table-sm" id="item_tableE" style="width: 100%;">
        <thead>
            <tr class="small">
                <th>#</th>
                <th>Tipo de Envase</th>
                <th>Material</th>
                <th>Cont. Neto</th>
                <th>Cont. Esc.</th>
                <th>Lapso de Aptitud</th>
                <th>Conservación</th>
                <th>Certificado</th>
                <th>Rótulo</th>
                @if ($modoEdicion)
                <th>Eliminar</th>
                @endif
            </tr>
        </thead>
        <tbody class="envase-group">
            @if(isset($rpadb->envases))
                @foreach ($rpadb->envases as $envase)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($modoEdicion)
                                <input type="text" class="form-control form-control-sm" name="envases[{{ $envase->id }}][tipo_envase]" value="{{ $envase->tipo_envase }}">
                            @else
                                {{ $envase->tipo_envase }}
                            @endif
                        </td>
                        <td>
                            @if ($modoEdicion)
                                <input type="text" class="form-control form-control-sm" name="envases[{{ $envase->id }}][material]" value="{{ $envase->material }}">
                            @else
                                {{ $envase->material }}
                            @endif
                        </td>
                        <td>
                            @if ($modoEdicion)
                                <input type="text" class="form-control form-control-sm" name="envases[{{ $envase->id }}][contenido_neto]" value="{{ $envase->contenido_neto }}">
                            @else
                                {{ $envase->contenido_neto }}
                            @endif
                        </td>
                        <td>
                            @if ($modoEdicion)
                                <input type="text" class="form-control form-control-sm" name="envases[{{ $envase->id }}][contenido_escurrido]" value="{{ $envase->contenido_escurrido }}">
                            @else
                                {{ $envase->contenido_escurrido }}
                            @endif
                        </td>
                        <td>
                            @if ($modoEdicion)
                                <input type="text" class="form-control form-control-sm" name="envases[{{ $envase->id }}][lapso_aptitud]" value="{{ $envase->lapso_aptitud }}">
                            @else
                                {{ $envase->lapso_aptitud }}
                            @endif
                        </td>
                        <td>
                            @if ($modoEdicion)
                                <input type="text" class="form-control form-control-sm" name="envases[{{ $envase->id }}][condiciones_conservacion]" value="{{ $envase->condiciones_conservacion }}">
                            @else
                                {{ $envase->condiciones_conservacion }}
                            @endif
                        </td>
                        <td>
                            @if ($modoEdicion)
                                <input type="file" class="form-control form-control-sm file-input" name="envases[{{ $envase->id }}][certificado_envase]"  data-preview="vistaPreviaCertificado_{{ $envase->id }}">
                                <div id="vistaPreviaCertificado_{{ $envase->id }}" class="mt-2">
                                    @if ($envase->ruta_cert_envase)
                                        <embed src="{{ url('/envase/' . $envase->id . '/certificado') }}" type="application/pdf" width="100%" height="150px">
                                        <button type="button" class="btn btn-danger btn-sm remove-file" data-target="vistaPreviaCertificado_{{ $envase->id }}"><i class="fas fa-trash"></i> Eliminar</button>
                                    @endif
                                </div>
                            @else
                                @if ($envase->ruta_cert_envase)
                                    <a href="{{ url('/envase/' . $envase->id . '/certificado') }}" target="_blank">Ver</a>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ($modoEdicion)
                                <input type="file" class="form-control form-control-sm file-input" name="envases[{{ $envase->id }}][rotulo_envase]" data-preview="vistaPreviaRotulo_{{ $envase->id }}">
                                <div id="vistaPreviaRotulo_{{ $envase->id }}" class="mt-2">
                                    @if ($envase->ruta_rotulo)
                                        <embed src="{{ url('/envase/' . $envase->id . '/rotulo') }}" type="application/pdf" width="100%" height="150px">
                                        <button type="button" class="btn btn-danger btn-sm remove-file" data-target="vistaPreviaRotulo_{{ $envase->id }}"><i class="fas fa-trash"></i> Eliminar</button>
                                    @endif
                                </div>
                            @else
                                @if ($envase->ruta_rotulo)
                                    <a href="{{ url('/envase/' . $envase->id . '/rotulo') }}" target="_blank">Ver</a>
                                @else
                                    <span class="text-muted">Sin archivo</span>
                                @endif
                            @endif
                        </td>
                        @if ($modoEdicion)
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @if ($modoEdicion)
        <button type="button" class="btn btn-success btn-sm addE"><i class="fas fa-plus"></i> Agregar Envase</button>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Evita múltiples ejecuciones
    if (window._envasesScriptCargado) return;
    window._envasesScriptCargado = true;

    // Eliminar archivo cargado
    document.querySelectorAll('.remove-file').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.dataset.target;
            const contenedor = document.getElementById(targetId);
            if (contenedor) {
                contenedor.innerHTML = '';
                const input = this.closest('td').querySelector('input[type="file"]');
                input.value = '';
            }
        });
    });

    let nuevoId = Date.now();

    const addButton = document.querySelector('.addE');
    if (addButton) {
        addButton.addEventListener('click', function () {
            const tabla = document.querySelector('#item_tableE tbody');
            if (!tabla) return;

            let html = '<tbody class="envase-group">';
            html += '<tr>'; // Primera fila de datos (inputs de texto)
            html += '<td>Nuevo</td>'; // Usar "Nuevo" para los envases recién agregados
            html += '<td><input type="text" class="form-control form-control-sm" name="envases[new_' + nuevoId + '][tipo_envase]" placeholder="Tipo de envase"></td>';
            html += '<td><input type="text" class="form-control form-control-sm" name="envases[new_' + nuevoId + '][material]"></td>';
            html += '<td><input type="text" class="form-control form-control-sm" name="envases[new_' + nuevoId + '][contenido_neto]"></td>';
            html += '<td><input type="text" class="form-control form-control-sm" name="envases[new_' + nuevoId + '][contenido_escurrido]"></td>';
            html += '<td><input type="text" class="form-control form-control-sm" name="envases[new_' + nuevoId + '][lapso_aptitud]"></td>';
            html += '<td><input type="text" class="form-control form-control-sm" name="envases[new_' + nuevoId + '][condiciones_conservacion]"></td>';
            html += '<td>'; // Celda para Certificado de envase
            html += '<input type="file" class="form-control form-control-sm file-input" name="envases[new_' + nuevoId + '][certificado_envase]" accept="application/pdf" data-preview="vistaPreviaCertificado_new_' + nuevoId + '">';
            html += '<div id="vistaPreviaCertificado_new_' + nuevoId + '" class="mt-2"></div>';
            html += '<button type="button" class="btn btn-danger btn-sm remove-file" data-target="vistaPreviaCertificado_new_' + nuevoId + '"><i class="fas fa-trash"></i> Eliminar</button>';
            html += '</td>';
            html += '<td>'; // Celda para Rótulo del envase
            html += '<input type="file" class="form-control form-control-sm file-input" name="envases[new_' + nuevoId + '][rotulo_envase]" accept="application/pdf" data-preview="vistaPreviaRotulo_new_' + nuevoId + '">';
            html += '<div id="vistaPreviaRotulo_new_' + nuevoId + '" class="mt-2"></div>';
            html += '<button type="button" class="btn btn-danger btn-sm remove-file" data-target="vistaPreviaRotulo_new_' + nuevoId + '"><i class="fas fa-trash"></i> Eliminar</button>';
            html += '</td>';
            html += '<td><button type="button" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td>'; // Botón eliminar envase
            html += '</tr>';

            html += '<tr><td colspan="10"><hr style="border-top: 3px solid #000; margin-top: 20px; margin-bottom: 20px;"></td></tr>'; // Línea separadora

            html += '</tbody>';

            tabla.insertAdjacentHTML('beforeend', html);
            nuevoId++;
            // Re-aplicar listeners a los nuevos inputs de archivo
            applyPreviewListeners();
            // Re-aplicar listeners a los nuevos botones de eliminar archivo
            applyRemoveFileListeners();
        });
    }

    const tabla = document.querySelector('#item_tableE');
    if (tabla) {
        tabla.addEventListener('click', function (e) {
            if (e.target.closest('.remove')) {
                e.target.closest('tr').remove(); // Eliminar solo la fila
            }
        });
    }

    // Función para aplicar listeners de vista previa a inputs de archivo
    function applyPreviewListeners() {
        document.querySelectorAll('.file-input').forEach(input => {
            // Remover listener existente para evitar duplicados
            const oldListener = input.dataset.previewListener;
            if (oldListener) {
                input.removeEventListener('change', window[oldListener]);
            }

            const newListenerName = 'previewListener_' + Date.now();
            window[newListenerName] = function() {
                const targetId = this.dataset.preview;
                if (targetId) {
                    generarVistaPrevia(this, targetId);
                }
            };
            input.addEventListener('change', window[newListenerName]);
            input.dataset.previewListener = newListenerName;
        });
    }

    // Función para aplicar listeners de eliminar archivo
    function applyRemoveFileListeners() {
        document.querySelectorAll('.remove-file').forEach(button => {
             // Remover listener existente para evitar duplicados
            const oldListener = button.dataset.removeListener;
            if (oldListener) {
                button.removeEventListener('click', window[oldListener]);
            }

            const newListenerName = 'removeListener_' + Date.now();
            window[newListenerName] = function() {
                const targetId = this.dataset.target;
                const contenedor = document.getElementById(targetId);
                if (contenedor) {
                    contenedor.innerHTML = '';
                    const input = this.closest('td').querySelector('input[type="file"]');
                    if (input) {
                        input.value = '';
                    }
                }
            };
            button.addEventListener('click', window[newListenerName]);
            button.dataset.removeListener = newListenerName;
        });
    }

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
                    embed.height = '150px'; // Ajustado a 150px para mejor visualización en la tabla
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

    // Aplicar listeners inicialmente y después de agregar nuevas filas
    applyPreviewListeners();
    applyRemoveFileListeners();

});
</script>
