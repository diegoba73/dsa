@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.rpadb.show', 'title' => __('Sistema DPSA')])

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detalle del Producto dado de Baja</h4>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Denominación:</strong><br>
                    {{ $rpadb->denominacion ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Nombre Fantasía:</strong><br>
                    {{ $rpadb->nombre_fantasia ?? '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Marca:</strong><br>
                    {{ $rpadb->marca ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Zona:</strong><br>
                    {{ $rpadb->dbredb->localidad->zona ?? 'Sin zona' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Fecha de Baja:</strong><br>
                    {{ $rpadb->fecha_baja ? \Carbon\Carbon::parse($rpadb->fecha_baja)->format('d/m/Y') : 'No registrada' }}
                </div>
                <div class="col-md-6">
                    <strong>Expediente:</strong><br>
                    {{ $rpadb->dbbaja->expediente ?? '-' }}
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <strong>Motivo de Baja:</strong><br>
                    {{ $rpadb->dbbaja->motivo ?? '-' }}
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('db_tramites_index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
