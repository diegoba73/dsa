@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.cepario.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Ingreso de Microorganismo</strong>
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
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/lab/cepario/') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                            <label class="bmd-label-floating">Número:</label>
                                            <input type="text" class="form-control form-control-sm" name="numero">
                                            <small class="form-text text-danger">* El número es requerido.</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Microorganismo:</label>
                                            <input type="text" class="form-control form-control-sm" name="microorganismo">
                                            <small class="form-text text-danger">* El nombre del microorganismo es requerido.</small>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Medio de Cultivo:</label>
                                            <input type="text" class="form-control form-control-sm" name="medio_cultivo">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Condiciones:</label>
                                            <input type="text" class="form-control form-control-sm" name="condiciones">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">TSI:</label>
                                            <input type="text" class="form-control form-control-sm" name="tsi">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Citrato:</label>
                                            <input type="text" class="form-control form-control-sm" name="citrato">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">LIA:</label>
                                            <input type="text" class="form-control form-control-sm" name="lia">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Urea:</label>
                                            <input type="text" class="form-control form-control-sm" name="urea">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">SIM:</label>
                                            <input type="text" class="form-control form-control-sm" name="sim">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Esculina:</label>
                                            <input type="text" class="form-control form-control-sm" name="esculina">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Hemólisis:</label>
                                            <input type="text" class="form-control form-control-sm" name="hemolisis">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Tumbling:</label>
                                            <input type="text" class="form-control form-control-sm" name="tumbling">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Fluorescencia:</label>
                                            <input type="text" class="form-control form-control-sm" name="fluorescencia">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Coagulasa:</label>
                                            <input type="text" class="form-control form-control-sm" name="coagulasa">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Oxidasa:</label>
                                            <input type="text" class="form-control form-control-sm" name="oxidasa">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Catalasa:</label>
                                            <input type="text" class="form-control form-control-sm" name="catalasa">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Gram:</label>
                                            <input type="text" class="form-control form-control-sm" name="gram">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm"for="proveedor_id">Proveedor</label>
                                            <select class="chosen-select" name="proveedor_id"> @foreach($proveedors as $proveedor)<option value="{{$proveedor->id}}">{{$proveedor->empresa}}</option>@endforeach </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Observaciones:</label>
                                            <input type="text" class="form-control form-control-sm" name="observaciones">
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('lab_cepario_index') }}">Cancelar</a>
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