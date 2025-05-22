@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'dsa.notas.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Editar Factura</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/dsa/facturas/'.$factura->id.'/edit') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha de Emisión:</label>
                                            <input type="date" class="form-control" id="datepicker" name="fecha_emision" value="{{ $factura->fecha_emision }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha de Pago:</label>
                                            <input type="date" class="form-control" id="datepicker" name="fecha_pago" value="{{ $factura->fecha_pago }}">
                                        </div>
                                    </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Depositante:</label>
                                            <input type="text" class="form-control" name="depositante" value="{{ $factura->depositante }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Detalle:</label>
                                            <input type="text" class="form-control" name="detalle" value="{{ $factura->detalle }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Importe:</label>
                                            <input type="text" class="form-control" name="importe" value="{{ $factura->importe }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Departamento:</label>
                                            <input type="text" class="form-control" name="departamento" value="{{ $factura->departamento }}">
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('dsa_facturas_index') }}">Cancelar</a>
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