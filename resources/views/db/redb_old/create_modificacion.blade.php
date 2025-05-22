@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.redb.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Inicio tramite de Modificación de Establecimiento Elaborador Provincial</strong>
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
                                    <form name="form_check" id="form_check" class="form-group form-prevent-multiple-submit" method="post" action="{{ route('db_redb_store_modificacion') }}" enctype="multipart/form-data"> 
                                    {{ csrf_field() }}
                                    <div class="row">

                                        </div>
                                        @foreach($dbempresa as $empresa)
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Empresa:</label>
                                                <input type="text" class="form-control form-control-sm" value="{{ $empresa->empresa }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Domicilio:</label>
                                                <input type="text" class="form-control form-control-sm" value="{{ $empresa->domicilio }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Ciudad:</label>
                                                <input type="text" class="form-control form-control-sm" value="{{ $empresa->ciudad }}" readonly>
                                                </div>
                                            </div>  
                                            <div class="col-1">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Provincia:</label>
                                                <input type="text" class="form-control form-control-sm" value="{{ $empresa->provincia }}" readonly>
                                                </div>
                                            </div> 
                                        </div>  
                                        @endforeach
                                        <hr>
                                        <h3>Establecimiento a modificar</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="form-group">
                                                <select class="chosen-select form-control form-control-md" name="establecimiento">
                                                    <option disabled selected>Seleccionar Establecimiento</option>
                                                    @foreach($redbs as $redb)
                                                    <option value="{{$redb->id}}">{{$redb->establecimiento}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <a class="btn btn-default btn-close" href="{{ route('db_redb_index') }}">Cancelar</a>          
                                                <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                            <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                            Iniciar
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