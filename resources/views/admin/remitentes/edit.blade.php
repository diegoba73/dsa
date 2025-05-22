@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'admin.remitentes.edit', 'title' => __('Sistema DPSA')])
@section('content')
<div class="header bg-primary pb-8 pt-5 pt-md-6">
        <div class="container-fluid">

                <div class="card-body">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            <div class="content bg-primary">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="alert alert-default">
                                    <strong class="card-title">Editar Remitente</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/admin/remitentes/'.$remitente->id.'/edit') }}">
                                    {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Remitente:</label>
                                            <input type="text" class="form-control" name="nombre" value="{{ $remitente->nombre }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">CUIT:</label>
                                            <input type="text" class="form-control" name="cuit" value="{{ $remitente->cuit }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Responsable:</label>
                                            <input type="text" class="form-control" name="responsable" value="{{ $remitente->responsable }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Área:</label>
                                            <input type="text" class="form-control" name="area" value="{{ $remitente->area }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">E-mail:</label>
                                            <input type="email" class="form-control" name="email" value="{{ $remitente->email }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Dirección:</label>
                                            <input type="text" class="form-control" name="direccion" value="{{ $remitente->direccion }}">
                                        </div>
                                        <div class="form-group">
                                                <label for="localidad">Localidad:</label><br>
                                                <select class="chosen-select" name="localidad_id" id="localidad">
                                                <option disabled selected>Seleccionar Localidad</option>
                                                            @foreach($localidads as $localidad)
                                                            <option value="{{$localidad->id}}" @if(($remitente->localidad_id) == ($localidad->id)) selected="selected" @endif>{{$localidad->localidad}}</option>
                                                            @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                                <label for="user_id">Usuario:</label><br>
                                                <select class="chosen-select" name="user_id" id="user_id">
                                                <option disabled selected>Seleccionar Usuario</option>
                                                            @foreach($users as $user)
                                                            <option value="{{$user->id}}" @if(($remitente->user_id) == ($user->id)) selected="selected" @endif>{{$user->usuario}}</option>
                                                            @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Teléfono:</label>
                                            <input type="text" class="form-control" name="telefono" value="{{ $remitente->telefono }}">
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('remitentes_index') }}">Cancelar</a>
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