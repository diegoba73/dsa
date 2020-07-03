@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.insumos.edit', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Editar Insumo</strong>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ url('/lab/insumos/'.$insumo->id.'/edit') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                    <div class="form-group">
                                            <label class="bmd-label-floating">Código:</label>
                                            <input type="text" class="form-control" name="codigo" value="{{ $insumo->codigo }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Nombre:</label>
                                            <input type="text" class="form-control" name="nombre" value="{{ $insumo->nombre }}">
                                        </div>
                                        @if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 8))
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Cromatografía:</label>
                                            {!! Form::checkbox('cromatografia', true, $insumo->cromatografia) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Química Alimentos:</label> 
                                            {!! Form::checkbox('quimica_al', true, $insumo->quimica_al) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Química Aguas:</label> 
                                            {!! Form::checkbox('quimica_ag', true, $insumo->quimica_ag) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Ensayo Biológico:</label>
                                            {!! Form::checkbox('ensayo_biologico', true, $insumo->ensayo_biologico) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Microbiología:</label>
                                            {!! Form::checkbox('microbiologia', true, $insumo->microbiologia) !!} &emsp;&emsp;
                                        </div>
                                        @elseif (Auth::user()->role_id == 3)
                                        <div class="form-group" style="display: none">
                                            <label class="bmd-label-floating">Química Alimentos:</label>
                                            {!! Form::checkbox('quimica_al', true, true) !!}
                                        </div>
                                        @elseif (Auth::user()->role_id == 4)
                                        <div class="form-group" style="display: none">
                                            <label class="bmd-label-floating">Química Agua:</label>
                                            {!! Form::checkbox('quimica_ag', true, true) !!}
                                        </div>
                                        @elseif (Auth::user()->role_id == 5)
                                        <div class="form-group" style="display: none">
                                            <label class="bmd-label-floating">Ensayo Biológico:</label>
                                            {!! Form::checkbox('ensayo_biologico', true, true) !!}
                                        </div>
                                        @elseif (Auth::user()->role_id == 6)
                                        <div class="form-group" style="display: none">
                                            <label class="bmd-label-floating">Cromatografía:</label>
                                            {!! Form::checkbox('cromatografia', true, true) !!}
                                        </div>
                                        @elseif (Auth::user()->role_id == 7)
                                        <div class="form-group" style="display: none">
                                            <label class="bmd-label-floating">Microbiología:</label>
                                            {!! Form::checkbox('microbiologia', true, true) !!}
                                        </div>
                                        @endif
                                            <div class="form-group">
                                            <label class="bmd-label-floating">Descripción:</label>
                                            <input type="text" class="form-control" name="descripcion" value="{{ $insumo->descripcion }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Costo:</label>
                                            <input type="text" class="form-control" name="costo" value="{{ $insumo->costo }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Proveedor que cotizó:</label>
                                            <input type="text" class="form-control" name="proveedor_cotizo" value="{{ $insumo->proveedor_cotizo }}">
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Fecha de cotización:</label>
                                            <input type="date" class="form-control form-control-sm" name="fecha_cotizacion" value="{{ $insumo->fecha_cotizacion }}">
                                        </div>
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('lab_insumos_index') }}">Cancelar</a>
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
@endsection