@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.muestras.fresultado', 'title' => __('Sistema DPSA')])
@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
                <div class="card-body">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        
                    <div class="col-md-16">
                            <div class="card">
                                <div class="alert alert-default">
                                    <strong>Datos Muestra Nº: {{$muestra->numero}}</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-prevent-multiple-submit" method="post" action="{{ url('/lab/muestras/'.$muestra->id.'/fresultado') }}">
                                        {{ csrf_field() }}
                                        <input name="url" type="hidden" value=$url>
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr><strong>
                                                    <th>Matriz</th>
                                                    <th>Tipo de Muestra</th>
                                                    <th>Muestra</th>
                                                    <th>Fecha de Entrada</th>
                                                    <th>Lugar de Extracción</th>
                                                    <th>Fecha de Extracción</th>
                                                    
                                                </strong>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> {{ $muestra->matriz->matriz }} </td>
                                                    <td> {{ $muestra->tipo_muestra }} </td>
                                                    <td> {{ $muestra->muestra }} </td>
                                                    <td>{{ date('d-m-Y', strtotime($muestra->fecha_entrada)) }}</td>
                                                    <td> {{ $muestra->lugar_extraccion }} </td>
                                                    <td>{{ date('d-m-Y', strtotime($muestra->fecha_extraccion)) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div>
                                        </div>
                                        <div class="col-md-12">
                                        <div class="card">
                                        <div class="card-header card-header-primary">
                                            <h4 class="card-title">INGRESO DE RESULTADOS</h4>
                                        </div>
                                        <div class="card-body">
                                        <div class="row">                                       
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de Inicio de Análisis:</label>
                                                    <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_inicio_analisis" value="{{ $muestra->fecha_inicio_analisis }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de Finalización de Análisis:</label>
                                                    <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_fin_analisis" value="{{ $muestra->fecha_fin_analisis }}">
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr><strong>
                                                    <th>Ensayo</th>
                                                    <th>Método</th>
                                                    <th>Resultado</th>
                                                    <th>Unidades</th>
                                                    
                                                </strong>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($muestra->ensayos as $ensayo)
                                                <tr>
                                                    <td> {{ $ensayo->ensayo }} </td>
                                                    <td> {{ $ensayo->metodo }} </td>
                                                    <td><input type="text" class="form-control form-control-sm" name="resultado[]" value="{{ $ensayo->pivot->resultado }}"></td>
                                                    <td> {{ $ensayo->unidades }} </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        
                                        @if ($muestra->cromatografia == 1 || $muestra->cromatografia == 'null')
                                        <div class="alert alert-default">
                                            <strong>Tabla de Analitos Hallados - Cromatografía</strong>
                                        </div>
                                        <table class="table rounded">
                                            <thead class="thead-dark">
                                                <tr><strong>
                                                    <th>Id</th>
                                                    <th>Analito</th>
                                                    <th>Valor Hallado</th>
                                                    <th>Unidades</th>
                                                    <th>Parámetros de Calidad</th>
                                                    <th>
                                                    </strong>
                                                    <a href="#" class="btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#agregar">
                                                    <i class="fas fa-plus"></i>
                                                        </a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                @foreach ($analitos as $analito)
                                                <tr>
                                                    <td> {{ $analito->id }} </td>
                                                    <td> {{ $analito->analito }} </td>
                                                    <td> {{ $analito->valor_hallado }} </td>
                                                    <td> {{ $analito->unidad }} </td>
                                                    <td> {{ $analito->parametro_calidad }} </td>
                                                    <td>
                                                        <a href="#" class="btn btn-warning btn-round btn-sm" data-anaid="{{$analito->id}}" data-anaanalito="{{$analito->analito}}" data-anavalor="{{$analito->valor_hallado}}" data-anaunidad="{{$analito->unidad}}" data-anaparametro="{{$analito->parametro_calidad}}"data-toggle="modal" data-target="#editar">
                                                        <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-danger btn-round btn-sm" data-anaid="{{$analito->id}}" data-anaanalito="{{$analito->analito}}" data-anavalor="{{$analito->valor_hallado}}" data-anaunidad="{{$analito->unidad}}" data-anaparametro="{{$analito->parametro_calidad}}"data-toggle="modal" data-target="#eliminar">
                                                        <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            
                                            </tbody>
                                            
                                        </table>
                                        @else
                                        @endif
                                        <div class="row">                                                                                                                                 
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Observaciones:</label>
                                                    {!! Form::textarea('observaciones', $muestra->observaciones, ['id' => 'observaciones', 'rows' => 4, 'cols' => 140]) !!}                                                    
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ route('lab_muestras_index') }}">Cancelar</a>
                                            <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                Cargar Resultados
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

<!-- Modal -->

<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Agregar Analito</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
        <form action="{{route('analito.store')}}" method="post">
      		{{csrf_field()}}
	      <div class="modal-body">

            <div class="form-group">
            <input type="hidden" class="form-control" name="id" value="{{$muestra->id}}">

                <div class="form-group">
                <label class="control-label col-sm-6"for="analito">Analito</label>
                    <div class="col-sm-6">
                    <input type="name" class="form-control form-control-sm" name="analito">
                    </div>
                </div>

                <div class="form-group">
                <label class="control-label col-sm-6"for="valor_hallado">Valor Hallado</label>
                    <div class="col-sm-6">
                    <input type="name" class="form-control form-control-sm" name="valor_hallado">
                    </div>
                </div>

                <div class="form-group">
                <label class="control-label col-sm-4"for="unidad">Unidad</label>
                    <div class="col-sm-4">
                    <input type="name" class="form-control form-control-sm" name="unidad">
                    </div>
                </div>

                <div class="form-group">
                <label class="control-label col-sm-6"for="parametro_calidad">Parametro de Calidad</label>
                    <div class="col-sm-6">
                    <input type="name" class="form-control form-control-sm" name="parametro_calidad">
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

<!-- Modal -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Editar Analito</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{route('analito.update', 'id')}}" method="post">
      		{{method_field('patch')}}
      		{{csrf_field()}}
	      <div class="modal-body">
                <div class="form-group">
                <input name="url" type="hidden" value="{{ $url }}">
                    <input type="hidden" class="form-control" name="id" id="id" value="">

                    <div class="form-group">
                    <label class="control-label col-sm-6"for="analito">Analito</label>
                        <div class="col-sm-6">
                        <input type="name" class="form-control form-control-sm" name="analito" id="analito">
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-6"for="valor_hallado">Valor Hallado</label>
                        <div class="col-sm-6">
                        <input type="name" class="form-control form-control-sm" name="valor_hallado" id="valor">
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-4"for="unidad">Unidad</label>
                        <div class="col-sm-4">
                        <input type="name" class="form-control form-control-sm" name="unidad" id="unidad">
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-6"for="parametro_calidad">Parametro de Calidad</label>
                        <div class="col-sm-6">
                        <input type="name" class="form-control form-control-sm" name="parametro_calidad" id="parametro">
                        </div>
                    </div>

                </div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar cambios</button>
	      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal modal-danger fade" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title text-center" id="myModalLabel">Eliminar Analito</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
      <form action="{{route('analito.destroy', 'test')}}" method="post">
      		{{method_field('delete')}}
      		{{csrf_field()}}
	      <div class="modal-body">
            <div class="form-group">
            <input name="url" type="hidden" value="{{ $url }}">
                <input type="hidden" class="form-control" name="id" id="id" value="">
                <div class="form-group">
                <p class="text-center">
					Se eliminará el analito selecciondo.
				</p>
                </div>
	        </div>
        </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
      </form>
    </div>
  </div>
</div>


@endsection