@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.ensayos.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Ingreso de Ensayo</strong>
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
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/lab/ensayos') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                            <label class="bmd-label-floating">Código:</label>
                                            <input type="text" class="form-control" name="codigo">
                                            <small class="form-text text-danger">* El código es requerido.</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Tipo de Ensayo:</label>
                                            <input type="text" class="form-control" name="tipo_ensayo">
                                            <small class="form-text text-danger">* El tipo de ensayo es requerido.</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Ensayo:</label>
                                            <input type="text" class="form-control" name="ensayo">
                                            <small class="form-text text-danger">* El nombre del ensayo es requerido.</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Método:</label>
                                            <input type="text" class="form-control" name="metodo">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Norma o Procedimiento:</label>
                                            <input type="text" class="form-control" name="norma_procedimiento">
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="matriz">Matriz:</label>
                                                <select class="chosen-select" name="matriz_id" id="matriz">
                                                            <option disabled selected>Seleccionar Matriz</option>
                                                            @foreach($matrizs as $matriz)
                                                            <option value="{{$matriz->id}}">{{$matriz->matriz}}</option>
                                                            @endforeach
                                                        </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Unidades:</label>
                                            <input type="text" class="form-control" name="unidades">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Valor de Referencia:</label>
                                            <input type="text" class="form-control" name="valor_referencia">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Límite de Cuantificación:</label>
                                            <input type="text" class="form-control" name="limite_c">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Límite de Detección:</label>
                                            <input type="text" class="form-control" name="limite_d">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Costo:</label>
                                            <input type="text" class="form-control" name="costo">
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('lab_muestras_index') }}">Cancelar</a>
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