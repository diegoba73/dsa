@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.baja.edit', 'title' => __('Sistema DPSA')])

@section('content')
<div class="header bg-primary pb-8 pt-5 pt-md-6">
    <div class="container-fluid">
        <div class="card-body">
            @if (session('notification'))
                <div class="alert alert-success">
                    {{ session('notification') }}
                </div>
            @endif
        </div>
        <div class="content bg-primary">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="alert alert-default">
                                <strong class="card-title">Editar Baja</strong>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('db_baja_update', $dbbaja->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    @if ($redb)
                                        <input type="hidden" name="redb_id" value="{{ $redb->id }}">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nro Exp.:</label>
                                                    <input type="text" class="form-control form-control-sm" name="expediente" value="{{ old('expediente', $dbbaja->expediente) }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Establecimiento:</label>
                                                    <input type="text" class="form-control form-control-sm" name="establecimiento" value="{{ old('establecimiento', $redb->establecimiento) }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Domicilio:</label>
                                                    <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ old('domicilio', $redb->domicilio) }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="localidad">Localidad:</label><br>
                                                    <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ old('localidad', $redb->localidad->localidad) }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($rpadb)
                                        <input type="hidden" name="rpadb_id" value="{{ $rpadb->id }}">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Motivo de la solicitud de producto:</label>
                                                    <input type="text" class="form-control form-control-sm" name="observaciones" value="{{ old('observaciones', $rpadb->observaciones) }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha de Baja:</label>
                                            <input type="date" value="{{ $dbbaja->fecha_baja ? $dbbaja->fecha_baja->format('Y-m-d') : '' }}" class="form-control" id="datepicker" name="fecha_baja">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Caja:</label>
                                        <input type="text" class="form-control" name="caja" value="{{ old('caja', $dbbaja->caja) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Motivo:</label>
                                        <input type="text" class="form-control" name="motivo" value="{{ old('motivo', $dbbaja->motivo) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Expediente:</label>
                                        <input type="text" class="form-control" name="expediente" value="{{ old('expediente', $dbbaja->expediente) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Nro registro:</label>
                                        <input type="text" class="form-control" name="nro_registro" value="{{ old('solicito', $dbbaja->nro_registro) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Solicitó:</label>
                                        <input type="text" class="form-control" name="solicito" value="{{ old('solicito', $dbbaja->solicito) }}">
                                    </div>
                                    <a class="btn btn-default btn-close" href="{{ route('db_tramites_index') }}">Cancelar</a>
                                    <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                        Guardar Cambios
                                    </button>
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
