<div id="envases" style="overflow-x: auto;">
    <label class="bmd-label-floating">Envases:</label>
    <table class="table table-bordered" id="item_tableE" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo de Envase</th>
                <th>Material</th>
                <th>Cont. Neto</th>
                <th>Cont. Esc.</th>
                <th>Lapso de Aptitud</th>
                <th>Conservación</th>
                <th>Certificado</th>
                <th>Rótulo</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody class="envase-group">
            @foreach ($rpadb->envases as $envase)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <input type="text" class="form-control" name="envases[{{ $envase->id }}][tipo_envase]" value="{{ $envase->tipo_envase }}">
                    </td>
                    <td>
                            <input type="text" class="form-control" name="envases[{{ $envase->id }}][material]" value="{{ $envase->material }}">
                    </td>
                    <td>
                            <input type="text" class="form-control" name="envases[{{ $envase->id }}][contenido_neto]" value="{{ $envase->contenido_neto }}">
                    </td>
                    <td>
                            <input type="text" class="form-control" name="envases[{{ $envase->id }}][contenido_escurrido]" value="{{ $envase->contenido_escurrido }}">
                    </td>
                    <td>
                            <input type="text" class="form-control" name="envases[{{ $envase->id }}][lapso_aptitud]" value="{{ $envase->lapso_aptitud }}">
                    </td>
                    <td>
                            <input type="text" class="form-control" name="envases[{{ $envase->id }}][condiciones_conservacion]" value="{{ $envase->condiciones_conservacion }}">
                    </td>
                    <td>
                            <input type="file" class="form-control" name="envases[{{ $envase->id }}][certificado_envase]">
                        @if ($envase->ruta_cert_envase)
                            <a href="{{ url('/envase/' . $envase->id . '/certificado') }}" target="_blank">Ver</a>
                        @endif
                    </td>
                    <td>
                            <input type="file" class="form-control" name="envases[{{ $envase->id }}][rotulo_envase]">
                        @if ($envase->ruta_rotulo)
                            <a href="{{ url('/envase/' . $envase->id . '/rotulo') }}" target="_blank">Ver</a>
                        @else
                            <span class="text-muted">Sin archivo</span>
                        @endif
                    </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button>
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>
        <button type="button" class="btn btn-success btn-sm addE"><i class="fas fa-plus"></i> Agregar Envase</button>
</div>
