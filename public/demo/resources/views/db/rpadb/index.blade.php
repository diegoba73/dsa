@extends('layouts.app')

@section('content')

    <div class="header bg-primary pb-1 pt-5 pt-md-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="content">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                    @if (session('danger'))
                        <div class="alert alert-danger">{{ session('danger') }}</div>
                    @endif
                <!-- Buscador -->
                    <div class="card bg-gradient-default mt-1 mb-1" style="margin: 0.5rem 0;">
                        <div class="card-body">
                            <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                                <div class="container-fluid">
                                <h2 style = "color: white">Buscador</h2>
                                {{ Form::open(['route' => 'db_rpadb_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group mr-2 mb-2">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('numero', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número', 'style' => 'height: 1.5rem;']) }}
                                        </div>
                                    </div>
                                    <div class="form-group mr-2">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('producto', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'producto', 'size'=>'45x5', 'style' => 'height: 1.5rem;']) }}
                                        </div>
                                    </div>
                                    <div class="form-group mr-1">
                                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm" href="{{ route('db_rpadb_index') }}">
                                            <i class="fas fa-redo fa-lg"></i>
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
    </div>
    
    <div class="container-fluid mt-2">
        <div class="row mt-2">
            <div class="col-xl-12 mb-2 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-gradient-default border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="mb-0" style="color:white">R.P.A.D.B.</h2>
                            </div>
                            <div class="col text-right">
                            <a href="#" class="btn btn-sm btn-success btn-close" data-toggle="modal" data-target="#">Consultas Registros en EXCEL</a>
                            @if (Auth::user()->role_id == 15 && Auth::user()->empresa)
                            <a href="{{ route('db_rpadb_create') }}" class="btn btn-sm btn-primary">Nuevo Registro</a>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Número</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Inscripción</th>
                                    <th scope="col">Reinscripción</th>
                                    <th scope="col">Baja</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    <tr>
                                    <form action="{{ route('lote') }}" method="POST">
                                        @csrf
                                        @foreach ($rpadbs as $rpadb)
                                        <td style="width:20px"><a class="text-white" href="#">{{ $rpadb->numero}}</a></td>
                                        <td style="width: 130px"><a class="text-white" href="{{ url('/rpadb/'.$rpadb->id.'/show')}}"><strong>{{ str_limit($rpadb->denominacion, 20)}}</strong></a></td>
                                        <td style="width:20px"><a class="text-white" href="#">{{ $rpadb->marca}}</a></td>
                                        <td style="width:20px">{{ date('d-m-Y', strtotime($rpadb->fecha_inscripcion)) }}</td>
                                        <td style="width:20px">{{ date('d-m-Y', strtotime($rpadb->fecha_reinscripcion)) }}</td>
                                        <td style="width:20px">{{ date('d-m-Y', strtotime($rpadb->fecha_baja)) }}</td>
                                        <td class="td-actions text-left">
                                            <a href="{{ url('/rpadb/'.$rpadb->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>  
                                            <a href="#" class="btn btn-danger btn-round btn-sm" data-srid="{{$rpadb->id}}" data-srregistro="{{$rpadb->producto}}" data-srentrada="{{$rpadb->marca}}" data-toggle="modal" data-target="#baja">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <a href="{{ url('/rpadb/'.$rpadb->id.'/certificado')}}" title="Certificado" rel="tooltip" class="btn btn-success btn-round btn-sm" target="_blank">
                                                <i class="fas fa-file"></i>
                                            </a>                               
                                        </td>
                                    </tr>
                                    @endforeach
                                    </form>
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:2em">
                        {{ $rpadbs->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    @include('layouts.footers.auth')
    </div>

<!-- Modal -->
<div class="modal modal-danger fade" id="baja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title text-center" id="myModalLabel">Realizar Baja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <form action="#" method="post">
      		{{method_field('patch')}}
      		{{csrf_field()}}
	      <div class="modal-body">
            <div class="row">
                <div class="col-7">
                    <label class="control-label col-sm"for="proveedor_id">fecha</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="fecha_baja" id="fecha_baja">
                        </div>
                </div>
                <div class="col-2">
                    <label class="control-label col-sm"for="pedido">rubro</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="rubro" id="rubro">
                        </div>
                </div>
            </div>
                </div>
                <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <br>
	      </div>
	      </div>
	     
      </form>
    </div>
  </div>
</div>

@endsection
