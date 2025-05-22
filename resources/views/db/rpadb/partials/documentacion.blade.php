<div class="row">
    {{-- MONOGRAFÍA --}}
    <div class="col-md-4 mb-3">
        <label>Monografía e información nutricional:</label>
        @if ($modoEdicion)
            <input type="file" class="form-control file-input" name="productos[0][monografia][]" multiple accept="application/pdf" data-preview="preview-monografia">
            <div id="preview-monografia" class="mt-2"></div>
        @endif

        @if ($rpadb->ruta_monografia)
            <ul class="list-group mt-2">
                @foreach(json_decode($rpadb->ruta_monografia, true) as $key => $ruta)
                    <li class="list-group-item d-flex align-items-center">
                        <div style="width:85%;">
                            {{ basename($ruta) }} —
                            <a href="{{ url('/rpadb/' . $rpadb->id . '/monografia/' . basename($ruta)) }}" target="_blank">Ver</a>
                            <div id="vistaPreviaMonografia_{{ $key }}" class="mt-2">
                                <embed src="{{ url('/rpadb/' . $rpadb->id . '/monografia/' . basename($ruta)) }}" type="application/pdf" width="100%" height="80px">
                            </div>
                        </div>
                        @if ($modoEdicion)
                            <button type="button" class="btn btn-danger btn-sm remove-file ml-2" data-target="vistaPreviaMonografia_{{ $key }}"><i class="fas fa-trash"></i> Eliminar</button>
                            <input type="checkbox" name="productos[0][delete_monografia][]" value="{{ $ruta }}" style="display:none;" id="chkMonografia_{{ $key }}">
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- COMPROBANTE DE PAGO --}}
    <div class="col-md-4 mb-3">
        <label>Comprobante de pago:</label>
        @if ($modoEdicion)
            <input type="file" class="form-control file-input" name="productos[0][pago]" accept="application/pdf" data-preview="preview-pago">
            <div id="preview-pago" class="mt-2"></div>
        @endif

        @if ($rpadb->ruta_pago)
            <ul class="list-group mt-2">
                <li class="list-group-item d-flex align-items-center">
                    <div style="width:85%;">
                        {{ basename($rpadb->ruta_pago) }} —
                        <a href="{{ url('/rpadb/' . $rpadb->id . '/pago/' . basename($rpadb->ruta_pago)) }}" target="_blank">Ver</a>
                        <div id="vistaPreviaPago" class="mt-2">
                            <embed src="{{ url('/rpadb/' . $rpadb->id . '/pago/' . basename($rpadb->ruta_pago)) }}" type="application/pdf" width="100%" height="80px">
                        </div>
                    </div>
                    @if ($modoEdicion)
                        <button type="button" class="btn btn-danger btn-sm remove-file ml-2" data-target="vistaPreviaPago"><i class="fas fa-trash"></i> Eliminar</button>
                        <input type="checkbox" name="productos[0][delete_pago]" value="{{ $rpadb->ruta_pago }}" style="display:none;" id="chkPago">
                    @endif
                </li>
            </ul>
        @endif
    </div>

    {{-- ANÁLISIS --}}
    <div class="col-md-4 mb-3">
        <label>Análisis:</label>
        @if ($modoEdicion)
            <input type="file" class="form-control file-input" name="productos[0][analisis][]" multiple accept="application/pdf" data-preview="preview-analisis">
            <div id="preview-analisis" class="mt-2"></div>
        @endif

        @if ($rpadb->ruta_analisis)
            <ul class="list-group mt-2">
                @foreach(json_decode($rpadb->ruta_analisis) as $i => $ruta)
                    <li class="list-group-item d-flex align-items-center">
                        <div style="width:85%;">
                            {{ basename($ruta) }} —
                            <a href="{{ url('/rpadb/' . $rpadb->id . '/analisis/' . basename($ruta)) }}" target="_blank">Ver</a>
                            <div id="vistaPreviaAnalisis_{{ $i }}" class="mt-2">
                                <embed src="{{ url('/rpadb/' . $rpadb->id . '/analisis/' . basename($ruta)) }}" type="application/pdf" width="100%" height="80px">
                            </div>
                        </div>
                        @if ($modoEdicion)
                            <button type="button" class="btn btn-danger btn-sm remove-file ml-2" data-target="vistaPreviaAnalisis_{{ $i }}"><i class="fas fa-trash"></i> Eliminar</button>
                            <input type="checkbox" name="productos[0][delete_analisis][]" value="{{ $ruta }}" style="display:none;" id="chkAnalisis_{{ $i }}">
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<div class="row">
    {{-- ESPECIFICACIONES --}}
    <div class="col-md-6 mb-3">
        <label>Especificaciones técnicas:</label>
        @if ($modoEdicion)
            <input type="file" class="form-control file-input" name="productos[0][especificaciones][]" multiple accept="application/pdf" data-preview="preview-especificaciones">
            <div id="preview-especificaciones" class="mt-2"></div>
        @endif

        @if ($rpadb->ruta_especificaciones)
            <ul class="list-group mt-2">
                @foreach(json_decode($rpadb->ruta_especificaciones) as $j => $ruta)
                    <li class="list-group-item d-flex align-items-center">
                        <div style="width:85%;">
                            {{ basename($ruta) }} —
                            <a href="{{ url('/rpadb/' . $rpadb->id . '/especificaciones/' . basename($ruta)) }}" target="_blank">Ver</a>
                            <div id="vistaPreviaEspecificaciones_{{ $j }}" class="mt-2">
                                <embed src="{{ url('/rpadb/' . $rpadb->id . '/especificaciones/' . basename($ruta)) }}" type="application/pdf" width="100%" height="80px">
                            </div>
                        </div>
                        @if ($modoEdicion)
                            <button type="button" class="btn btn-danger btn-sm remove-file ml-2" data-target="vistaPreviaEspecificaciones_{{ $j }}"><i class="fas fa-trash"></i> Eliminar</button>
                            <input type="checkbox" name="productos[0][delete_especificaciones][]" value="{{ $ruta }}" style="display:none;" id="chkEspecificaciones_{{ $j }}">
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Elimina todos los listeners previos y resetea inputs
    document.querySelectorAll('.file-input').forEach(function(input) {
        input.outerHTML = input.outerHTML;
    });

    document.querySelectorAll('.file-input').forEach(function(input) {
        // Nueva lógica para manejar archivos seleccionados y su preview
        let archivosSeleccionados = []; // Mantiene la lista de archivos seleccionados por este input

        input.addEventListener('change', function (event) {
            // Reset array y vista previa al seleccionar nuevos archivos
            archivosSeleccionados = Array.from(this.files);

            const containerId = this.dataset.preview;
            const previewContainer = document.getElementById(containerId);
            if (previewContainer) previewContainer.innerHTML = '';

            archivosSeleccionados.forEach(function(file, idx) {
                if (file.type === 'application/pdf') {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const divItem = document.createElement('div');
                        divItem.className = 'mb-2 d-flex align-items-center';

                        const embed = document.createElement('embed');
                        embed.src = e.target.result;
                        embed.type = 'application/pdf';
                        embed.width = '90%';
                        embed.height = '80px';
                        embed.style.marginRight = '8px';

                        // Botón eliminar para el archivo seleccionado
                        const btnEliminar = document.createElement('button');
                        btnEliminar.type = 'button';
                        btnEliminar.className = 'btn btn-danger btn-sm ml-2';
                        btnEliminar.innerHTML = '<i class="fas fa-trash"></i> Eliminar';

                        btnEliminar.onclick = function () {
                            // Elimina del array y vuelve a renderizar el input y las previews
                            archivosSeleccionados.splice(idx, 1);

                            // Actualiza FileList en el input usando DataTransfer
                            const dt = new DataTransfer();
                            archivosSeleccionados.forEach(f => dt.items.add(f));
                            input.files = dt.files;

                            // Vuelve a renderizar la vista previa
                            input.dispatchEvent(new Event('change'));
                        };

                        divItem.appendChild(embed);
                        divItem.appendChild(btnEliminar);
                        previewContainer.appendChild(divItem);
                    };
                    reader.readAsDataURL(file);
                } else {
                    const msg = document.createElement('p');
                    msg.textContent = `"${file.name}" no es un archivo PDF válido y no será subido.`;
                    msg.classList.add('text-danger', 'small');
                    if (previewContainer) previewContainer.appendChild(msg);
                }
            });
        });
    });

    // --- Eliminar archivos subidos ya existentes ---
    document.querySelectorAll('.remove-file').forEach(function(button) {
        button.onclick = function () {
            const targetId = this.dataset.target;
            const previewDiv = document.getElementById(targetId);
            const checkboxEliminar = this.closest('li').querySelector('input[type="checkbox"]');
            if (checkboxEliminar) checkboxEliminar.checked = true;
            if (previewDiv) previewDiv.innerHTML = '';
            // Cambiar el botón por uno verde "Eliminado"
            const eliminadoBtn = document.createElement('button');
            eliminadoBtn.type = 'button';
            eliminadoBtn.className = 'btn btn-success btn-sm ml-2';
            eliminadoBtn.disabled = true;
            eliminadoBtn.textContent = 'Eliminado';
            this.parentNode.replaceChild(eliminadoBtn, this);
        }
    });
});
</script>

