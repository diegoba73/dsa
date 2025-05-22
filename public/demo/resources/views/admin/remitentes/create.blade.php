@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'admin.remitentes.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Ingreso de Remitente</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/admin/remitentes') }}">
                                    {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Remitente:</label>
                                            <input type="text" class="form-control" name="nombre">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">CUIT:</label>
                                            <input type="text" class="form-control" name="cuit">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Responsable:</label>
                                            <input type="text" class="form-control" name="responsable">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Área:</label>
                                            <input type="text" class="form-control" name="area">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">E-mail:</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Dirección:</label>
                                            <input type="text" class="form-control" name="direccion">
                                        </div>
                                        <div class="form-group">
                                                <label for="localidad">Localidad:</label><br>
                                                <select class="chosen-select" name="localidad_id" id="localidad">
                                                <option disabled selected>Seleccionar Localidad</option>
                                                            @foreach($localidads as $localidad)
                                                            <option value="{{$localidad->id}}">{{$localidad->localidad}}</option>
                                                            @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                                <label for="user_id">Usuario:</label><br>
                                                <select class="chosen-select" name="user_id" id="user_id">
                                                <option disabled selected>Seleccionar Usuario</option>
                                                            @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->usuario}}</option>
                                                            @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Teléfono:</label>
                                            <input type="text" class="form-control" name="telefono">
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