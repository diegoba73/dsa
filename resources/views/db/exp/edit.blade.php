@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.exp.edit', 'title' => __('Sistema DPSA')])
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
                                <strong class="card-title">Editar datos del Expediente</strong>
                            </div>
                            <div class="card-body">
                                <form class="form-group form-prevent-multiple-submit" method="post" action="{{ route('db_exp_update', $dbexp->id) }}">
                                    @csrf
                                    @method('PUT') <!-- Usa PUT para actualizaciones -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha:</label>
                                            <input type="date" class="form-control" id="datepicker" name="fecha" value="{{ old('fecha', $dbexp->fecha ?? now()->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Descripción:</label>
                                        <input type="text" class="form-control" name="descripcion" value="{{ old('descripcion', $dbexp->descripcion) }}">
                                    </div>
                                    <a class="btn btn-default btn-close" href="{{ route('db_exp_index') }}">Cancelar</a>
                                    <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                        Actualizar
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