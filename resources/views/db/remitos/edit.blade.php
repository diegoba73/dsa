@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.remitos.edit', 'title' => __('Sistema DPSA')])
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
                                    <form method="post" action="{{ url('/remitos/'.$db_remito->id.'/edit') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="remitente">Remitente:</label><br>
                                                    <select class="chosen-select" name="remitente">
                                                        <option disabled selected>Seleccionar Remitente</option>
                                                        @foreach($remitentes as $remitente)
                                                        <option value="{{$remitente->id}}" @if(($db_remito->remitente_id) == ($remitente->id)) selected="selected" @endif>{{$remitente->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-danger">* El Remitente es requerida.</small>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha:</label>
                                            <input type="date" value="{{$db_remito->fecha}}" class="form-control form-control-sm" id="datepicker" name="fecha">
                                        </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Nro de Nota:</label>
                                                <input type="text" class="form-control form-control-sm" name="nro_nota" value="{{$db_remito->nro_nota}}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <br>
                                            <a href="#" class="btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#agregarnota">
                                                Nº Nota
                                            </a>
                                        </div>
                                    </div>
                                        <div class="form-group">
                                            {!! Form::Label('muestras', 'Muestras:') !!}
                                            <select class="chosen-select" name="muestras[]" multiple="multiple">
                                            @forelse($selects as $sel)
                                                @foreach($muestras as $muestra)
                                                <option value="{{$muestra->id}}" @if(($sel->muestra_id) == ($muestra->id)) selected="selected" @endif>{{$muestra->numero}} / {{$muestra->muestra }}</option>
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
                                            <input type="text" class="form-control form-control-sm" name="conclusion" value="{{ $db_remito->conclusion }}">
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('db_remitos_index') }}">Cancelar</a>
                                        <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    Actualizar
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
<!-- Modal -->

<div class="modal fade" id="agregarnota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Agregar NºNota</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
        <form action="{{route('notaremito')}}" method="post">
      		{{csrf_field()}}
	      <div class="modal-body">

            <div class="form-group">
                <div class="form-group">
                <label class="control-label col-sm-6"for="fecha">Fecha</label>
                    <div class="col-sm-6">
                    <input type="date" class="form-control form-control-sm" name="fecha">
                    </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-6"for="descripcion">Descripción</label>
                    <div class="col-sm-6">
                    <input type="name" class="form-control form-control-sm" name="descripcion">
                    </div>
                </div>
            </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar</button>
	      </div>
        </form>
    </div>
  </div>
</div>   
@endsection