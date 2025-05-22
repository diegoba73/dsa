@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.reactivos.edit', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Editar Reactivo</strong>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ url('/lab/reactivos/'.$reactivo->id.'/edit') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Código:</label>
                                            <input type="text" class="form-control" name="codigo" value="{{ $reactivo->codigo }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Nombre:</label>
                                            <input type="text" class="form-control" name="nombre" value="{{ $reactivo->nombre }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Descripción:</label>
                                            <input type="text" class="form-control form-control-sm" name="descripcion" value="{{ $reactivo->descripcion }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Nro CAS:</label>
                                            <input type="text" class="form-control" name="numero_cas" value="{{ $reactivo->numero_cas }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Ensayo:</label>
                                            <input type="text" class="form-control" name="ensayo" value="{{ $reactivo->ensayo }}">
                                        </div>
                                        @if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 8))
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Cromatografía:</label>
                                            {!! Form::checkbox('cromatografia', true, $reactivo->cromatografia) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Química:</label> 
                                            {!! Form::checkbox('quimica', true, $reactivo->quimica) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Ensayo Biológico:</label>
                                            {!! Form::checkbox('ensayo_biologico', true, $reactivo->ensayo_biologico) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Microbiología:</label>
                                            {!! Form::checkbox('microbiologia', true, $reactivo->microbiologia) !!} &emsp;&emsp;
                                        </div>
                                        @elseif ((Auth::user()->role_id == 3) || (Auth::user()->role_id == 4))
                                        <div class="form-group" style="display: none">
                                            <label class="bmd-label-floating">Química:</label>
                                            {!! Form::checkbox('quimica', true, $reactivo->quimica) !!}
                                        </div>
                                        @elseif (Auth::user()->role_id == 5)
                                        <div class="form-group" style="display: none">
                                            <label class="bmd-label-floating">Ensayo Biológico:</label>
                                            {!! Form::checkbox('ensayo_biologico', true, $reactivo->ensayo_biologico) !!}
                                        </div>
                                        @elseif (Auth::user()->role_id == 6)
                                        <div class="form-group" style="display: none">
                                            <label class="bmd-label-floating">Cromatografía:</label>
                                            {!! Form::checkbox('cromatografia', true, $reactivo->cromatografia) !!}
                                        </div>
                                        @elseif (Auth::user()->role_id == 7)
                                        <div class="form-group" style="display: none">
                                            <label class="bmd-label-floating">Microbiología:</label>
                                            {!! Form::checkbox('microbiologia', true, $reactivo->microbiologia) !!}
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label class="bmd-label-floating">RENPRE:</label>
                                            {!! Form::checkbox('renpre', true, $reactivo->renpre) !!}
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Costo:</label>
                                            <input type="text" class="form-control" name="costo" value="{{ $reactivo->costo }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Proveedor que cotizó:</label>
                                            <input type="text" class="form-control" name="proveedor_cotizo" value="{{ $reactivo->proveedor_cotizo }}">
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Fecha de Cotización:</label>
                                            <input type="date" class="form-control form-control-sm" name="fecha_cotizacion" value="{{ $reactivo->fecha_cotizacion }}">
                                        </div>
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('lab_reactivos_index') }}">Cancelar</a>
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