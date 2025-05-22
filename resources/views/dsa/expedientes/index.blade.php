@extends('layouts.app')

@section('content')

    <div class="header bg-primary pb-8 pt-5 pt-md-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="content">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif  
                <!-- Buscador -->
                <div class="card bg-gradient-default mt-3 mb-2 mb-lg-0">
                <div class="card-body">
                <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                    <div class="container-fluid">
                    <h2 style = "color: white">Buscador</h2>
                    {{ Form::open(['route' => 'dsaexpedientes_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                    <div class="form-group mr-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('descripcion', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Descripción', 'style' => 'height: 1.5rem;']) }}
                        </div>
                    </div>
                    <div class="form-group mr-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('nro_nota', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Nro Nota', 'style' => 'height: 1.5rem;']) }}
                        </div>
                    </div>
                    <div class="form-group mr-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('nro_expediente', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Nro Expediente', 'style' => 'height: 1.5rem;']) }}
                        </div>
                    </div>
                    <div class="form-group mr-1">
                    <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="form-group mr-1">
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm" href="{{ route('dsaexpedientes_index') }}">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                    {{ Form::close() }}
                    </div>
                </nav>
                </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid mt--8">
        <div class="row mt-9">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-gradient-default border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0" style="color:white">Expedientes</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('dsaexpedientes_create') }}" class="btn btn-sm btn-primary">Nuevo Expediente</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Nro Nota</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Fecha inicio</th>
                                    <th scope="col">Fecha expediente</th>
                                    <th scope="col">Nro Exp.</th>
                                    <th scope="col">Costo total</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($dsaexpedientes as $dsaexpediente)
                                                <tr>
                                                    <td><a href="#" style="color: white;" class="editar-exp" data-toggle="modal" data-target="#modificar_exp" data-expid="{{$dsaexpediente->id}}" data-expnro_nota="{{$dsaexpediente->nro_nota}}" data-expnro_expediente="{{$dsaexpediente->nro_expediente}}" data-expdescripcion="{{$dsaexpediente->descripcion}}" data-expfecha_expediente="{{$dsaexpediente->fecha_expediente}}" data-expestado="{{$dsaexpediente->estado}}" data-expobservaciones="{{$dsaexpediente->observaciones}}" data-expcosto_total="{{$dsaexpediente->costo_total}}">{{ $dsaexpediente->id}}</td>
                                                    <td><a href="#" style="color: white;" class="editar-exp" data-toggle="modal" data-target="#modificar_exp" data-expid="{{$dsaexpediente->id}}" data-expnro_nota="{{$dsaexpediente->nro_nota}}" data-expnro_expediente="{{$dsaexpediente->nro_expediente}}" data-expdescripcion="{{$dsaexpediente->descripcion}}" data-expfecha_expediente="{{$dsaexpediente->fecha_expediente}}" data-expestado="{{$dsaexpediente->estado}}" data-expobservaciones="{{$dsaexpediente->observaciones}}" data-expcosto_total="{{$dsaexpediente->costo_total}}">{{ $dsaexpediente->nro_nota}}</td>
                                                    <td><a href="#" style="color: white;" class="editar-exp" data-toggle="modal" data-target="#modificar_exp" data-expid="{{$dsaexpediente->id}}" data-expnro_nota="{{$dsaexpediente->nro_nota}}" data-expnro_expediente="{{$dsaexpediente->nro_expediente}}" data-expdescripcion="{{$dsaexpediente->descripcion}}" data-expfecha_expediente="{{$dsaexpediente->fecha_expediente}}" data-expestado="{{$dsaexpediente->estado}}" data-expobservaciones="{{$dsaexpediente->observaciones}}" data-expcosto_total="{{$dsaexpediente->costo_total}}">{{ str_limit($dsaexpediente->descripcion, 30)}}</td>
                                                    <td>{{ date('d-m-Y', strtotime($dsaexpediente->created_at)) }}</td>
                                                    @if (strtotime($dsaexpediente->fecha_expediente) > 0)
                                                    <td>{{ date('d-m-Y', strtotime($dsaexpediente->fecha_expediente)) }}</td>
                                                    @else
                                                    <td><span class="badge badge-pill badge-warning">SIN EXPEDIENTE</span></td>
                                                    @endif
                                                    <td>{{ $dsaexpediente->nro_expediente}}</td>
                                                    <td>{{ $dsaexpediente->costo_total}}</td>
                                                    <td>{{ $dsaexpediente->estado}}</td>
                                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $dsaexpedientes->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>

<!-- Modal -->

<div class="modal fade" id="modificar_exp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" style="max-width: 1200px;" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Modificar datos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>
        <form action="{{ route('dsaexpediente_modificar', ['id' => $dsaexpediente->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $dsaexpediente->id }}">
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm"for="nro_nota">Nro Nota</label>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm col-2" name="nro_nota" id="nro_nota">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm"for="descripcion">Descripcion</label>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm col-12" name="descripcion" id="descripcion">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm"for="nro_expediente">Nro Expediente</label>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm col-2" name="nro_expediente" id="nro_expediente">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm"for="fecha_expediente">Fecha Expediente</label>
                    <div class="form-group">
                        <input type="date" class="form-control form-control-sm col-2" name="fecha_expediente" id="fecha_expediente">
                    </div>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" class="form-control form-control-sm col-3" id="estado" class="form-control">
                        <option value="INICIO" @if($dsaexpediente->estado == 'INICIO') selected @endif>INICIO</option>
                        <option value="ASIGNADO" @if($dsaexpediente->estado == 'ASIGNADO') selected @endif>ASIGNADO</option>
                        <option value="EN TRAMITE" @if($dsaexpediente->condicion == 'EN TRAMITE') selected @endif>EN TRAMITE</option>
                        <option value="ADJUDICADO" @if($dsaexpediente->estado == 'ADJUDICADO') selected @endif>ADJUDICADO</option>
                        <option value="FINALIZADO" @if($dsaexpediente->estado == 'FINALIZADO') selected @endif>FINALIZADO</option>
                    </select>
                </div>                                            
                <div class="form-group">
                    <label class="control-label col-sm"for="observaciones">Observaciones</label>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm col-12" name="observaciones" id="observaciones">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm"for="costo_total">Costo Total</label>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm col-2" name="costo_total" id="costo_total">
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