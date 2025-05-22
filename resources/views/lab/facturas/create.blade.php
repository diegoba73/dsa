@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'dsa.facturas.create', 'title' => __('Sistema DPSA')])
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
                                            @foreach ($errors->all() as $messages)
                                            <li>{{$messages}}</li>
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
                                    <strong class="card-title">Ingreso de Factura</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/lab/facturas') }}">
                                    {{ csrf_field() }}
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha de Emisión:</label>
                                            <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="datepicker" name="fecha_emision">
                                        </div>
                                    </div>
                                    <div class="col">
                                            <div class="form-group">
                                                <label for="departamento">Departamento:</label><br>
                                                        <select class="chosen-select" name="departamento">
                                                            <option disabled selected>Seleccionar Departamento</option>
                                                            @foreach($departamentos as $departamento)
                                                            <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* El Departamento es requerido.</small>
                                            </div>
                                                <div class="form-group">
                                                <label for="remitente">Remitente:</label><br>
                                                        <select class="chosen-select" name="remitente">
                                                            <option disabled selected>Seleccionar Remitente</option>
                                                            @foreach($remitentes as $remitente)
                                                            <option value="{{$remitente->id}}">{{$remitente->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-danger">* El Solicitante es requerido.</small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Ítems del Nomenclador:</label>
                                                <select class="chosen-select" id="nomenclador-select" name="selected_nomencladors[]" multiple>
                                                    @if ($userRoleID == 1) <!-- Si el rol del usuario es admin -->
                                                        @foreach ($nomencladors as $nomenclador)
                                                            <option value="{{ $nomenclador->id }}" data-departamento="{{ $nomenclador->departamento_id }}">
                                                                {{ $nomenclador->descripcion }}
                                                            </option>
                                                        @endforeach
                                                    @else <!-- Si el usuario no es admin -->
                                                        @foreach ($nomencladors as $nomenclador)
                                                            @if ($nomenclador->departamento_id == $userDepartamentoId)
                                                                <option value="{{ $nomenclador->id }}" data-departamento="{{ $nomenclador->departamento_id }}">
                                                                    {{ $nomenclador->descripcion }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <table class="table" id="selected-nomencladors-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Ítem</th>
                                                            <th>Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Aquí se agregarán las filas de ítems seleccionados -->
                                                    </tbody>
                                                </table>
                                            </div>

                                        <a class="btn btn-default btn-close" href="{{ route('facturas_index') }}">Cancelar</a>
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