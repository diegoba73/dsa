<div class="row">
    {{-- MONOGRAFÍA --}}
    <div class="col-md-4 mb-3">
        <label>Monografía e información nutricional:</label>
        @if ($modoEdicion)
            <input type="file" class="form-control file-input" name="productos[0][monografia][]" multiple accept="application/pdf" data-preview="preview-monografia">
            <div id="preview-monografia" class="mt-2">
                @isset($monografia_preview_html)
                    {!! $monografia_preview_html !!}
                @endisset
            </div>
        @endif

        @if ($rpadb->ruta_monografia)
            <ul class="list-group mt-2">
                @foreach(json_decode($rpadb->ruta_monografia, true) as $key => $ruta)
                    <li class="list-group-item archivo-cargado" id="monografia-prevista-{{ $key }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="width: 85%">
                                {{ basename($ruta) }} —
                                <a href="{{ url('/rpadb/' . $rpadb->id . '/monografia/' . basename($ruta)) }}" target="_blank">Ver</a>
                                <embed src="{{ url('/rpadb/' . $rpadb->id . '/monografia/' . basename($ruta)) }}" type="application/pdf" width="100%" height="60px" style="display:block; margin-top:7px;">
                            </span>
                            @if ($modoEdicion)
                                <button type="button" class="btn btn-danger btn-sm remove-file align-middle"
                                    data-target="item-monografia-{{ $key }}"
                                    data-prevista="monografia-prevista-{{ $key }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <input type="checkbox" name="productos[0][delete_monografia][]" value="{{ $ruta }}" style="display:none;" id="item-monografia-{{ $key }}">
                            @endif
                        </div>
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
            <div id="preview-pago" class="mt-2">
                @isset($pago_preview_html)
                    {!! $pago_preview_html !!}
                @endisset
            </div>
        @endif

        @if ($rpadb->ruta_pago)
            <ul class="list-group mt-2">
                <li class="list-group-item archivo-cargado" id="pago-prevista">
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="width: 85%">
                            {{ basename($rpadb->ruta_pago) }} —
                            <a href="{{ url('/rpadb/' . $rpadb->id . '/pago/' . basename($rpadb->ruta_pago)) }}" target="_blank">Ver</a>
                            <embed src="{{ url('/rpadb/' . $rpadb->id . '/pago/' . basename($rpadb->ruta_pago)) }}" type="application/pdf" width="100%" height="60px" style="display:block; margin-top:7px;">
                        </span>
                        @if ($modoEdicion)
                            <button type="button" class="btn btn-danger btn-sm remove-file align-middle"
                                data-target="item-pago"
                                data-prevista="pago-prevista">
                                <i class="fas fa-trash"></i>
                            </button>
                            <input type="checkbox" name="productos[0][delete_pago]" value="{{ $rpadb->ruta_pago }}" style="display:none;" id="item-pago">
                        @endif
                    </div>
                </li>
            </ul>
        @endif
    </div>

    {{-- ANÁLISIS --}}
    <div class="col-md-4 mb-3">
        <label>Análisis:</label>
        @if ($modoEdicion)
            <input type="file" class="form-control file-input" name="productos[0][analisis][]" multiple accept="application/pdf" data-preview="preview-analisis">
            <div id="preview-analisis" class="mt-2">
                @isset($analisis_preview_html)
                    {!! $analisis_preview_html !!}
                @endisset
            </div>
        @endif

        @if ($rpadb->ruta_analisis)
            <ul class="list-group mt-2">
                @foreach(json_decode($rpadb->ruta_analisis) as $i => $ruta)
                    <li class="list-group-item archivo-cargado" id="analisis-prevista-{{ $i }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="width: 85%">
                                {{ basename($ruta) }} —
                                <a href="{{ url('/rpadb/' . $rpadb->id . '/analisis/' . basename($ruta)) }}" target="_blank">Ver</a>
                                <embed src="{{ url('/rpadb/' . $rpadb->id . '/analisis/' . basename($ruta)) }}" type="application/pdf" width="100%" height="60px" style="display:block; margin-top:7px;">
                            </span>
                            @if ($modoEdicion)
                                <button type="button" class="btn btn-danger btn-sm remove-file align-middle"
                                    data-target="item-analisis-{{ $i }}"
                                    data-prevista="analisis-prevista-{{ $i }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <input type="checkbox" name="productos[0][delete_analisis][]" value="{{ $ruta }}" style="display:none;" id="item-analisis-{{ $i }}">
                            @endif
                        </div>
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
            <div id="preview-especificaciones" class="mt-2">
                @isset($especificaciones_preview_html)
                    {!! $especificaciones_preview_html !!}
                @endisset
            </div>
        @endif

        @if ($rpadb->ruta_especificaciones)
            <ul class="list-group mt-2">
                @foreach(json_decode($rpadb->ruta_especificaciones) as $j => $ruta)
                    <li class="list-group-item archivo-cargado" id="especificaciones-prevista-{{ $j }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="width: 85%">
                                {{ basename($ruta) }} —
                                <a href="{{ url('/rpadb/' . $rpadb->id . '/especificaciones/' . basename($ruta)) }}" target="_blank">Ver</a>
                                <embed src="{{ url('/rpadb/' . $rpadb->id . '/especificaciones/' . basename($ruta)) }}" type="application/pdf" width="100%" height="60px" style="display:block; margin-top:7px;">
                            </span>
                            @if ($modoEdicion)
                                <button type="button" class="btn btn-danger btn-sm remove-file align-middle"
                                    data-target="item-especificaciones-{{ $j }}"
                                    data-prevista="especificaciones-prevista-{{ $j }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <input type="checkbox" name="productos[0][delete_especificaciones][]" value="{{ $ruta }}" style="display:none;" id="item-especificaciones-{{ $j }}">
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

@push('scripts')
<script>
function applyPreviewListeners() {
    document.querySelectorAll('.file-input').forEach(input => {
        input.addEventListener('change', function () {
            const containerId = this.dataset.preview;
            const previewContainer = document.getElementById(containerId);
            const files = this.files;

            previewContainer.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                if (file.type !== 'application/pdf') {
                    const msg = document.createElement('p');
                    msg.textContent = `"${file.name}" no es un archivo PDF válido.`;
                    msg.classList.add('text-danger');
                    previewContainer.appendChild(msg);
                    continue;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    const iframe = document.createElement('iframe');
                    iframe.src = e.target.result;
                    iframe.width = '100%';
                    iframe.height = '400';
                    iframe.classList.add('mb-3');
                    previewContainer.appendChild(iframe);
                };
                reader.readAsDataURL(file);
            }
        });
    });
}

// Manejo visual del botón de eliminar
function applyRemoveFileListeners() {
    document.querySelectorAll('.remove-file').forEach(btn => {
        btn.addEventListener('click', function () {
            const target = this.dataset.target;
            const prevista = this.dataset.prevista;
            // Marcar el checkbox oculto
            const checkbox = document.getElementById(target);
            if (checkbox) {
                checkbox.checked = true;
            }
            // Ocultar la previa del archivo y la fila
            if (prevista) {
                const fila = document.getElementById(prevista);
                if (fila) fila.style.display = 'none';
            } else if (this.closest('li')) {
                this.closest('li').style.display = 'none';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    applyPreviewListeners();
    applyRemoveFileListeners();
});
</script>
@endpush
