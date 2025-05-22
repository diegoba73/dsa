@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.rpadb.create_baja', 'title' => __('Sistema DPSA')])

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Gestión de Baja del Producto</h4>
        </div>
        <div class="card-body">
            <h5><strong>Producto:</strong> {{ $rpadb->denominacion }}</h5>
            <p><strong>Nombre Fantasía:</strong> {{ $rpadb->nombre_fantasia }}</p>
            <p><strong>Marca:</strong> {{ $rpadb->marca }}</p>
            <p><strong>Zona:</strong> {{ $rpadb->dbredb->localidad->zona ?? 'Sin zona' }}</p>

            @if($tramite->observaciones)
                <div class="alert alert-secondary mt-4">
                    <strong>Observaciones de Solicitud:</strong><br>
                    {{ $tramite->observaciones }}
                </div>
            @endif

            <div class="mt-4">
                {{-- Mostrar botones de acción según rol y estado --}}
                @php
                    $user = Auth::user();
                    $estado = $tramite->estado;
                @endphp

                {{-- Área: Evaluar Baja --}}
                @if (in_array($user->role_id, [16,17,18]) && $estado === 'INICIADO')
                    <form method="POST" action="{{ route('rpadb.evaluar_baja', $rpadb->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            Evaluar Baja
                        </button>
                    </form>
                @endif

                {{-- NC: Aprobar Baja --}}
                @if ($user->role_id === 9 && in_array($estado, ['INICIADO', 'EVALUADO POR AREA PROGRAMATICA']))
                    <form method="POST" action="{{ route('rpadb.aprobar_baja', $rpadb->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Aprobar Baja
                        </button>
                    </form>
                @endif

                {{-- ADMIN: Registrar Baja --}}
                @if ($user->role_id === 1 && $estado === 'APROBADO')
                    <form method="POST" action="{{ route('rpadb.store_baja', $rpadb->id) }}">
                        @csrf

                        <div class="form-group mt-3">
                            <label for="fecha_baja">Fecha de Baja:</label>
                            <input type="date" name="fecha_baja" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="caja">Caja:</label>
                            <input type="text" name="caja" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="motivo">Motivo:</label>
                            <input type="text" name="motivo" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="solicito">Solicitado por:</label>
                            <input type="text" name="solicito" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="expediente">Número de Expediente:</label>
                            <input type="text" name="expediente" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">
                            Registrar Baja
                        </button>
                    </form>
                @endif

                <div class="mt-4">
                    <a href="{{ route('db_tramites_index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
