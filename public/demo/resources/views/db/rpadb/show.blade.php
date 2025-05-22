@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.muestras.show', 'title' => __('Sistema DPSA')])
@section('content')
<br>
<div class="container bg-primary" style="height: auto;">
  <div class="row justify-content-center">
  


            <div class="content bg-primary">
                <div class="container-fluid">
                
                        <!-- Buscador -->
                        <div class="card bg-gradient-default mb-2">
                        <div class="card-body">
                        <h2 style = "color: white">Buscador</h2>
                            <div class="container-fluid">
                            
                            {{ Form::open(['route' => 'lab_muestras_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="input-group input-group-alternative">
                                        {{ Form::text('numero', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row align-items-end">
                                    <div class="col">
                                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                                        <i class="fas fa-search"></i>
                                        </button>
                                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('lab_muestras_index') }}">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div> 
                            </div>

                            {{ Form::close() }}
                            </div>
                        </div>
                        </div>
                    <div class="row">
                        
                        <div class="col-md-16">
                            <div class="card">
                                <div class="alert alert-default">
                                    <strong class="card-title">Muestra Nº {{$muestra->numero}}</strong>
                                    <div style="float:right;">
                                    @if ($muestra->revisada === 1)
                                    <strong class="card-title">Revisada</strong>
                                    <i class="fas fa-check fa-2x text-green"></i>
                                    @else
                                    
                                    @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="form-prevent-multiple-submit" method="post" action="{{ url('/lab/muestras/'.$muestra->id.'/edit') }}">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="solicitante">Solicitante:</label><br>
                                                            <input type="text" class="form-control form-control-sm" value="{{$muestra->solicitante}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="entrada">Entrada:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{$muestra->entrada}}" readonly>
                                                </div> 
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="tipo_prestacion">Tipo de Prestación:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{$muestra->tipo_prestacion}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="remitente">Remitente:</label><br>
                                                <input type="text" class="form-control form-control-sm" value="{{ $muestra->remitente ? $muestra->remitente->nombre : '' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col">
                                            <div class="form-group">
                                            <label for="matriz">Matriz:</label><br>
                                                <input type="text" class="form-control form-control-sm" value="{{$muestra->matriz->matriz}}" readonly>                                        
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                        <label for="tipomuestra_id">Tipo de Muestra:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{$muestra->tipomuestra->tipo_muestra}}" readonly> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Muestra:</label>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $muestra->muestra }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nº Cert. Cadena de Custodia:</label>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $muestra->nro_cert_cadena_custodia }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Identificación:</label>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $muestra->identificacion }}" readonly>
                                                </div>
                                            </div>                                        
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="label-control">Fecha de Entrada:</label>
                                                     <input type="date" class="form-control form-control-sm" value="{{ $muestra->fecha_entrada }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Realizó Muestreo:</label>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $muestra->realizo_muestreo }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="divmas">
                                            <a data-toggle="collapse" href="#collapseDatos" aria-expanded="false" aria-controls="collapseDatos" id="mas">
                                            Más Datos  <i class="fas fa-arrow-down"></i>
                                            </a>
                                        </div>
                                        <div class="collapse" id="collapseDatos">
                                            <div class="row">
                                                <div class="col">
                                                <div class="form-group">
                                                    <label for="provincia">Provincia:</label><br>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $muestra->provincia->provincia }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                    <label for="localidad">Localidad:</label><br>
                                                    <input type="text" class="form-control form-control-sm" value="{{ $muestra->localidad->localidad }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Lugar de Extracción:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->lugar_extraccion }}" readonly>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                        <div class="form-group">
                                                            <label class="label-control">Fecha de Extracción:</label>
                                                            <input type="date" class="form-control form-control-sm" value="{{ $muestra->fecha_extraccion }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Hora Extración:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->hora_extraccion }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Conservación:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->conservacion }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Cloro:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->cloro_residual }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Tipo de Envase:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->tipo_envase }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Cantidad:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->cantidad }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Peso/Volúmen:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->peso_volumen }}" readonly>
                                                    </div>
                                                </div>
                                                @if (Auth::user()->departamento_id == 3 || Auth::user()->departamento_id == 4)
                                                <tr></tr>
                                                @else
                                                </div>
                                                <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Fecha de Elaborado:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->fecha_elaborado }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Fecha de Vencimiento:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->fecha_vencimiento }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Elaborado por:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->elaborado_por }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Marca:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->marca }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Domicilio</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->domicilio }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                        
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Reg. de Establecimiento:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->registro_establecimiento }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Reg. de Producto:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->registro_producto }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Lote:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->lote }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Partida:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->partida }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Destino:</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $muestra->destino }}" readonly>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            
                                            <div id="divmenos" style="display: none">
                                            <a data-toggle="collapse" href="#collapseDatos" aria-expanded="false" aria-controls="collapseDatos" id="menos">
                                                Menos Datos  <i class="fas fa-arrow-up"></i>
                                            </a>
                                        </div>
                                        </div>
                                        <br>
                                        <div class="border border-danger rounded">
                                            <div class="row">
                                                <div class="col-md-16">
                                                    <br>
                                                    <div class="form-group ml-4">
                                                        <table>
                                                            <thead>
                                                            <th><strong>Ensayos: </strong></th>
                                                            @if ($muestra->cargada === 1)
                                                            <th><strong>Resultado: </strong></th>
                                                            @else
                                                            <th></th>
                                                            @endif
                                                            </thead>
                                                            <tbody>
                                                            @foreach($muestra->ensayos as $ensayo)
                                                            <tr>
                                                                <td style="width:400px;">{{$ensayo->ensayo}}</td>
                                                                <td>{{$ensayo->pivot->resultado}}</td>
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <a class="btn btn-default btn-close" href="{{ route('lab_muestras_index') }}">Cancelar</a>
                                            @if (($muestra->revisada === null) || ($muestra->revisada === 0))
                                                @if ((Auth::user()->departamento_id == 1) && ($muestra->aceptada === 1))
                                                    <a class="btn btn-info btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/ht')}}" target="_blank">Hoja de Trabajo</a>
                                                @endif
                                                @if (Auth::user()->departamento_id == 1)
                                                    <a class="btn btn-warning btn-close" href="{{ route('devolver_muestra', $muestra->id) }}">Devolver</a>
                                                    <a class="btn btn-danger btn-close" href="{{ route('lab_muestras_rechazo', $muestra->id) }}">Rechazar</a>
                                                    @if (($muestra->aceptada == 0) || ($muestra->aceptada === null))
                                                    <a class="btn btn-success btn-close" href="{{ route('aceptar_muestra', $muestra->id) }}">Aceptar</a> 
                                                    @endif
                                                @endif
                                                @if (($muestra->aceptada === null) || ($muestra->aceptada === 0) || (Auth::user()->id == 2))
                                                    <a class="btn btn-primary btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/edit')}}">Editar</a>
                                                @endif
                                                @if (($muestra->aceptada === 1) && ((Auth::user()->id == 6) || (Auth::user()->id == 30 || (Auth::user()->id == 4))))
                                                    <a class="btn btn-primary btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/edit')}}">Editar</a>
                                                @endif
                                                @if ((Auth::user()->departamento_id == 1) && ($muestra->cargada == 1))
                                                    <a class="btn btn-success btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado')}}" target="_blank">Imprimir Resultado</a> 
                                                @endif
                                                @if (($muestra->cargada == 1) && ((Auth::user()->departamento_id == 1) && (Auth::user()->role_id == 1)))
                                                    <a class="btn btn-outline-success" href="{{ route('muestra_revisada', $muestra->id) }}">Revisada</a>
                                                @endif
                                            @elseif (($muestra->revisada === 1) && ((Auth::user()->departamento_id == 1) && (Auth::user()->role_id == 1)))
                                                <a class="btn btn-primary btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/edit')}}">Editar</a>
                                                <a class="btn btn-danger btn-close" href="{{ route('muestra_vrevisar', $muestra->id) }}">Volver a Revisar</a>
                                                <a class="btn btn-success btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado')}}" target="_blank">Imprimir Resultado</a> 
                                                <a class="btn btn-primary btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado_firma')}}" target="_blank">Imprimir Resultado Firmado</a>
                                            @elseif (($muestra->revisada === 1) && (Auth::user()->departamento_id == 1))
                                                <a class="btn btn-success btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado')}}" target="_blank">Imprimir Resultado</a>                                         
                                                <a class="btn btn-primary btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado_firma')}}" target="_blank">Imprimir Resultado Firmado</a>
                                                <a class="btn btn-primary btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_traducido')}}" target="_blank">Imprimir Resultado Traducido</a>
                                            @elseif (($muestra->revisada == 1) && ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 13)))
                                                <a class="btn btn-primary btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado_firma')}}" target="_blank">Imprimir Resultado Firmado</a>
                                            @endif
                                            @if (($muestra->revisada === 1) && ((Auth::user()->id == 6) || (Auth::user()->id == 30) || (Auth::user()->id == 4)))
                                                    <a class="btn btn-primary btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/edit')}}">Editar</a>
                                            @endif
                                            @if (Auth::user()->role_id == 1)
                                                    @if (($muestra->aceptada == 0))
                                                    <a class="btn btn-danger btn-close" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_rechazo')}}" target="_blank">Imprimir rechazo</a>
                                                    @endif
                                            @endif
                                            @if ((Auth::user()->role_id <> 13) && ($muestra->revisada === 1))
                                            <a href="#" class="btn btn-success btn-close" data-toggle="modal" data-target="#agregarcondicion">
                                                Ingresar Condición
                                            </a>
                                            @endif
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

<div class="modal fade" id="agregarcondicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Ingrese la condicion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>
        <form action="{{ route('condicion', ['id' => $muestra->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $muestra->id }}">
            <div class="modal-body">
                <div class="form-group">
                    <label for="condicion">Condición</label>
                    <select name="condicion" id="condicion" class="form-control">
                        <option value="Sin/Conclusión" @if($muestra->condicion == 'Sin/Conclusión') selected @endif>Sin/Conclusión</option>
                        <option value="Cumple" @if($muestra->condicion == 'Cumple') selected @endif>Cumple</option>
                        <option value="No Cumple" @if($muestra->condicion == 'No Cumple') selected @endif>No Cumple</option>
                        <option value="Cumple con observaciones" @if($muestra->condicion == 'Cumple con observaciones') selected @endif>Cumple con observaciones</option>
                        <option value="No Aplica" @if($muestra->condicion == 'No Aplica') selected @endif>No Aplica</option>
                        <option value="Rechazada" @if($muestra->condicion == 'Rechazada') selected @endif>Rechazada</option>
                    </select>
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
