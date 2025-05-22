<div class="row">
    {{-- MONOGRAFÍA --}}
    <div class="col-md-6 mb-3">
        <label>Monografía e información nutricional:</label>
        <input type="file" class="form-control file-input" name="productos[0][monografia][]" accept="application/pdf" multiple data-preview="preview-monografia">
        <div id="preview-monografia" class="mt-2"></div>

        @if ($rpadb->ruta_monografia)
            <ul class="list-group mt-2">
                @foreach(json_decode($rpadb->ruta_monografia, true) as $ruta)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            {{ basename($ruta) }} —
                            <a href="{{ url('/rpadb/' . $rpadb->id . '/monografia/' . basename($ruta)) }}" target="_blank">Ver</a>
                        </span>
                        <div class="form-check ml-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="productos[0][delete_monografia][]" value="{{ $ruta }}">
                                <span class="form-check-sign">Eliminar</span>
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- COMPROBANTE DE PAGO --}}
    <div class="col-md-6 mb-3">
        <label>Comprobante de pago:</label>
        <input type="file" class="form-control file-input" name="productos[0][pago]" accept="application/pdf" data-preview="preview-pago">
        <div id="preview-pago" class="mt-2"></div>

        @if ($rpadb->ruta_pago)
            <ul class="list-group mt-2">
                <li class="list-group-item">
                    {{ basename($rpadb->ruta_pago) }} —
                    <a href="{{ url('/rpadb/' . $rpadb->id . '/pago/' . basename($rpadb->ruta_pago)) }}" target="_blank">Ver</a>
                    <label><input type="checkbox" name="productos[0][delete_pago]" value="{{ $rpadb->ruta_pago }}"> Eliminar</label>
                </li>
            </ul>
        @endif
    </div>
</div>

<div class="row">
    {{-- ANÁLISIS --}}
    <div class="col-md-6 mb-3">
        <label>Análisis:</label>
        <input type="file" class="form-control file-input" name="productos[0][analisis][]" accept="application/pdf" multiple data-preview="preview-analisis">
        <div id="preview-analisis" class="mt-2"></div>

        @if ($rpadb->ruta_analisis)
            <ul class="list-group mt-2">
                @foreach(json_decode($rpadb->ruta_analisis) as $ruta)
                    <li class="list-group-item">
                        {{ basename($ruta) }} —
                        <a href="{{ url('/rpadb/' . $rpadb->id . '/analisis/' . basename($ruta)) }}" target="_blank">Ver</a>
                        <label><input type="checkbox" name="productos[0][delete_analisis][]" value="{{ $ruta }}"> Eliminar</label>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- ESPECIFICACIONES --}}
    <div class="col-md-6 mb-3">
        <label>Especificaciones técnicas:</label>
        <input type="file" class="form-control file-input" name="productos[0][especificaciones][]" accept="application/pdf" multiple data-preview="preview-especificaciones">
        <div id="preview-especificaciones" class="mt-2"></div>

        @if ($rpadb->ruta_especificaciones)
            <ul class="list-group mt-2">
                @foreach(json_decode($rpadb->ruta_especificaciones) as $ruta)
                    <li class="list-group-item">
                        {{ basename($ruta) }} —
                        <a href="{{ url('/rpadb/' . $rpadb->id . '/especificaciones/' . basename($ruta)) }}" target="_blank">Ver</a>
                        <label><input type="checkbox" name="productos[0][delete_especificaciones][]" value="{{ $ruta }}"> Eliminar</label>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<script>
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
</script>
