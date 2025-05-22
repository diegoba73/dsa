@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'admin.proveedores.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Ingreso de Proveedor</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/admin/proveedores') }}">
                                    {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Empresa:</label>
                                            <input type="text" class="form-control" name="empresa">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Contacto:</label>
                                            <input type="text" class="form-control" name="contacto">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Teléfono:</label>
                                            <input type="text" class="form-control" name="telefono">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">E-mail:</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Tipo de Insumos:</label>
                                            <input type="text" class="form-control" name="tipo_insumo">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Criticidad:</label>
                                            <input type="text" class="form-control" name="criticidad">
                                        </div>
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