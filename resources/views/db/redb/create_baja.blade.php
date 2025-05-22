@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.redb.create_baja', 'title' => __('Sistema DPSA')])

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
                                <strong class="card-title">Baja</strong>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('redb.store_baja', ['id' => $redb->id]) }}" method="POST">
                                    {{ csrf_field() }}
                                    @if ($redb)
                                        <input type="hidden" name="redb_id" value="{{ $redb->id }}">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nro Exp.:</label>
                                                    <input type="text" class="form-control form-control-sm" name="expediente" value="{{ $tramite->dbexp->numero ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Establecimiento:</label>
                                                <input type="text" class="form-control form-control-sm" name="establecimiento" value="{{ $redb->establecimiento }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Domicilio:</label>
                                                <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ $redb->domicilio }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="localidad">Localidad:</label><br>
                                                    <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ $redb->localidad->localidad }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($tramite->observaciones) && $tramite->observaciones !== '')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Motivo de la solicitud de producto:</label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control form-control-sm" 
                                                            name="observaciones" 
                                                            value="{{ $tramite->observaciones }}" 
                                                            {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @elseif ($rpadb)
                                        <input type="hidden" name="rpadb_id" value="{{ $rpadb->id }}">
                                        @if(isset($tramite->observaciones) && $tramite->observaciones !== '')
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Motivo de la solicitud de producto:</label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control form-control-sm" 
                                                            name="observaciones" 
                                                            value="{{ $tramite->observaciones }}" 
                                                            {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha:</label>
                                            <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="datepicker" name="fecha_baja">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Caja:</label>
                                        <input type="text" class="form-control" name="caja">
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Motivo:</label>
                                        <input type="text" class="form-control" name="motivo">
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Descripción:</label>
                                        <input type="text" class="form-control" name="descripcion">
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Expediente:</label>
                                        <input type="text" class="form-control" name="expediente">
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Solicito:</label>
                                        <input type="text" class="form-control" name="solicito">
                                    </div>
                                    <a class="btn btn-default btn-close" href="{{ route('db_tramites_index') }}">Cancelar</a>
                                    <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                        Registrar Baja
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
