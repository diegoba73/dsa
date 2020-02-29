@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.mesaentrada.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Ingreso a Mesa de Entradas</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/db/mesaentrada') }}">
                                    {{ csrf_field() }}
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha Ingreso:</label>
                                            <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="datepicker" name="fecha_ingreso">
                                        </div>
                                    </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Descripción:</label>
                                            <input type="text" class="form-control" name="descripcion">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Destino:</label>
                                            <input type="text" class="form-control" name="destino">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Nro Nota Remitida:</label>
                                            <input type="text" class="form-control" name="nro_nota_remitida">
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('db_me_index') }}">Cancelar</a>
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
</div>   
@endsection