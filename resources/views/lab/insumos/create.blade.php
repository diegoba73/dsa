@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.insumos.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Ingreso de Insumo</strong>
                                </div>
                                <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/lab/insumos/') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                            <label class="bmd-label-floating">Código:</label>
                                            <input type="text" class="form-control form-control-sm" name="codigo">
                                            <small class="form-text text-danger">* El código es requerido.</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Nombre:</label>
                                            <input type="text" class="form-control form-control-sm" name="nombre">
                                            <small class="form-text text-danger">* El nombre es requerido.</small>
                                        </div>
                                        @if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 8))
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Cromatografía:</label>
                                            {!! Form::checkbox('cromatografia', true, NULL) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Química Alimentos:</label> 
                                            {!! Form::checkbox('quimica_al', true, NULL) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Química Aguas:</label> 
                                            {!! Form::checkbox('quimica_ag', true, NULL) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Ensayo Biológico:</label>
                                            {!! Form::checkbox('ensayo_biologico', true, NULL) !!} &emsp;&emsp;
                                            <label class="bmd-label-floating">Microbiología:</label>
                                            {!! Form::checkbox('microbiologia', true, NULL) !!} &emsp;&emsp;
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
                                                <input type="text" class="form-control" name="descripcion">
                                            </div>
                                            <div class="form-group">
                                            <label class="bmd-label-floating">Costo:</label>
                                            <input type="text" class="form-control form-control-sm" name="costo">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Proveedor que cotizó:</label>
                                            <input type="text" class="form-control form-control-sm" name="proveedor_cotizo">
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha de Cotizacion:</label>
                                                <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_cotizacion" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('lab_reactivos_index') }}">Cancelar</a>
                                        <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    Ingresar
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