@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.empresa.create', 'title' => __('Sistema DPSA')])
@section('content')
{{ Form::hidden('url', URL::full()) }}
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                                    <strong class="card-title">Ingreso Nueva Empresa</strong>
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
                                    <form name="form_check" id="form_check" class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/empresa/') }}" enctype="multipart/form-data"> 
                                    {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-1">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">CUIT:</label>
                                                <input type="number" class="form-control form-control-sm" name="cuit">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Empresa:</label>
                                                <input type="text" class="form-control form-control-sm" name="empresa">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Domicilio:</label>
                                                <input type="text" class="form-control form-control-sm" name="domicilio">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Ciudad:</label>
                                                <input type="text" class="form-control form-control-sm" name="ciudad">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Provincia:</label>
                                                <input type="text" class="form-control form-control-sm" name="provincia">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Telefono:</label>
                                                <input type="text" class="form-control form-control-sm" name="telefono">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">E-mail:</label>
                                                <input type="text" class="form-control form-control-sm" name="email">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div> 
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="user_id">Usuario:</label><br>
                                                    <select class="chosen-select" name="user_id" id="user_id">
                                                    <option disabled selected>Seleccionar Usuario</option>
                                                                @foreach($users as $user)
                                                                <option value="{{$user->id}}">{{$user->usuario}}</option>
                                                                @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ route('db_empresa_index') }}">Cancelar</a>          
                                        <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    Ingresar
                                        </button>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</div> 
@endsection