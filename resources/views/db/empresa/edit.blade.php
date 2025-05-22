@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.empresa.edit', 'title' => __('Sistema DPSA')])
@section('content')
{{ Form::hidden('url', URL::full()) }}
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
                            <li>{{$error}}</li>
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
                                    <strong class="card-title">Modificando Empresa {{$dbempresa->empresa}}</strong>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('db_empresa_update', $dbempresa->id) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-1">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">CUIT:</label>
                                                <input type="number" class="form-control form-control-sm" name="cuit" value="{{ $dbempresa->cuit }}">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Empresa:</label>
                                                <input type="text" class="form-control" name="empresa" value="{{ $dbempresa->empresa }}">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Domicilio:</label>
                                                <input type="text" class="form-control" name="domicilio" value="{{ $dbempresa->domicilio }}">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Ciudad:</label>
                                                    <input type="text" class="form-control" name="ciudad" value="{{ $dbempresa->ciudad }}">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Provincia:</label>
                                                <input type="text" class="form-control" name="provincia" value="{{ $dbempresa->provincia }}">
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Teléfono:</label>
                                                <input type="text" class="form-control" name="telefono" value="{{ $dbempresa->telefono }}">
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">E-mail:</label>
                                                <input type="text" class="form-control" name="email" value="{{ $dbempresa->email }}">
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="user_id">Usuario:</label><br>
                                                    <select class="chosen-select" name="user_id" id="user_id" 
                                                        @if(Auth::user()->role_id == 15) 
                                                            disabled 
                                                        @endif
                                                    >
                                                        <option disabled>Seleccionar Usuario</option>
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}" {{ $user->id == $dbempresa->user_id ? 'selected' : '' }}>
                                                                {{ $user->usuario }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">    
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label for="dni">DNI ARCHIVO:</label>
                                                    <input type="file" class="form-control" name="dni" id="dni">
                                                    @if($dbempresa->ruta_dni)
                                                        <a href="{{ route('verDNI', $dbempresa->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label for="cuit">CUIT ARCHIVO:</label>
                                                    <input type="file" class="form-control" name="cuit" id="cuit">
                                                    <small class="form-text text-danger">*Solo incluir si no es unipersonal.</small>
                                                    @if($dbempresa->ruta_cuit)
                                                        <a href="{{ route('verCUIT', $dbempresa->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label for="estatuto">ESTATUTO/CONTRATO:</label>
                                                    <input type="file" class="form-control" name="estatuto" id="estatuto">
                                                    @if($dbempresa->ruta_estatuto)
                                                        <a href="{{ route('verESTATUTO', $dbempresa->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                            <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit" name="submit">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                Actualizar
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
</div>   
@endsection
