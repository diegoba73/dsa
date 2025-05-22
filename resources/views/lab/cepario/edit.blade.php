@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.cepario.edit', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Editar Microorganismo</strong>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ url('/lab/cepario/'.$microorganismo->id.'/edit') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                    <div class="form-group">
                                            <label class="bmd-label-floating">Número:</label>
                                            <input type="text" class="form-control" name="numero" value="{{ $microorganismo->numero }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Microorganismo:</label>
                                            <input type="text" class="form-control" name="microorganismo" value="{{ $microorganismo->microorganismo }}">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Medio de Cultivo:</label>
                                                <input type="text" class="form-control" name="medio_cultivo" value="{{ $microorganismo->medio_cultivo }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Condiciones:</label>
                                                <input type="text" class="form-control" name="condiciones" value="{{ $microorganismo->condiciones }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">TSI:</label>
                                                <input type="text" class="form-control" name="tsi" value="{{ $microorganismo->tsi }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Citrato:</label>
                                                <input type="text" class="form-control" name="citrato" value="{{ $microorganismo->citrato }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">LIA:</label>
                                                <input type="text" class="form-control" name="lia" value="{{ $microorganismo->lia }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Urea:</label>
                                                <input type="text" class="form-control" name="urea" value="{{ $microorganismo->urea }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">SIM:</label>
                                                <input type="text" class="form-control" name="sim" value="{{ $microorganismo->sim }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Esculina:</label>
                                                <input type="text" class="form-control" name="esculina" value="{{ $microorganismo->esculina }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Hemólisis:</label>
                                                <input type="text" class="form-control" name="hemolisis" value="{{ $microorganismo->hemolisis }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Tumbling:</label>
                                                <input type="text" class="form-control" name="tumbling" value="{{ $microorganismo->tumbling }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Fluorescencia:</label>
                                                <input type="text" class="form-control" name="fluorescencia" value="{{ $microorganismo->fluorescencia }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Coagulasa:</label>
                                                <input type="text" class="form-control" name="coagulasa" value="{{ $microorganismo->coagulasa }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Oxidasa:</label>
                                                <input type="text" class="form-control" name="oxidasa" value="{{ $microorganismo->oxidasa }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Catalasa:</label>
                                                <input type="text" class="form-control" name="catalasa" value="{{ $microorganismo->catalasa }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Gram:</label>
                                                <input type="text" class="form-control" name="gram" value="{{ $microorganismo->gram }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="proveedor_id">Proveedor:</label><br>
                                                        <select class="chosen-select" name="proveedor_id">
                                                            <option disabled selected>Seleccionar Proveedor</option>
                                                            @foreach($proveedors as $proveedor)
                                                            <option value="{{$proveedor->id}}" @if(($microorganismo->proveedor_id) == ($proveedor->id)) selected="selected" @endif>{{$proveedor->empresa}}</option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Observaciones:</label>
                                                <input type="text" class="form-control" name="observaciones" value="{{ $microorganismo->observaciones }}">
                                            </div>
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