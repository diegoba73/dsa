@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'dso.remitos.edit', 'title' => __('Sistema DPSA')])
@section('content')
<div class="header bg-primary pb-8 pt-5 pt-md-6">
<div class="container-">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                                    <strong>Editar Remito</strong>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ url('/dso/remitos/'.$dso_remito->id.'/edit') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                            <div class="form-group">
                                                <label for="remitente">Remitente:</label><br>
                                                    <select class="chosen-select" name="remitente">
                                                        <option disabled selected>Seleccionar Remitente</option>
                                                        @foreach($remitentes as $remitente)
                                                        <option value="{{$remitente->id}}" @if(($dso_remito->remitente_id) == ($remitente->id)) selected="selected" @endif>{{$remitente->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-danger">* El Remitente es requerida.</small>

                                            </div>
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha:</label>
                                            <input type="date" value="{{$dso_remito->fecha}}" class="form-control form-control-sm" id="datepicker" name="fecha">
                                        </div>
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Nro de Nota:</label>
                                            <input type="text" class="form-control form-control-sm" name="nro_nota" value="{{$dso_remito->nro_nota}}">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::Label('muestras', 'Muestras:') !!}
                                            <select class="chosen-select" name="muestras[]" multiple="multiple">
                                            @forelse($selects as $sel)
                                                @foreach($muestras as $muestra)
                                                <option value="{{$muestra->id}}" @if(($sel->muestra_id) == ($muestra->id)) selected="selected" @endif>{{$muestra->numero}} / {{$muestra->tipo_muestra }} / {{$muestra->muestra }}</option>
                                                @endforeach
                                            @empty
                                                @foreach($muestras as $muestra)
                                                <option value="{{$muestra->id}}">{{$muestra->numero}} / {{$muestra->tipo_muestra }} / {{$muestra->muestra }}</option>
                                                @endforeach
                                            @endforelse
                                            </select>
                                            </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Conclusión:</label>
                                            
                                            <textarea class="form-control" name="conclusion" rows="10" cols="80">
                                            {{ $dso_remito->conclusion }}
                                            </textarea>
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha Salida:</label>
                                            <input type="date" value="{{$dso_remito->fecha_salida}}" class="form-control form-control-sm" id="datepicker" name="fecha_salida">
                                        </div>
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('dso_remitos_index') }}">Cancelar</a>
                                        <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    Ingresar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <div>
            </div>
    </div>
</div>   
@endsection