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
                    @if (Auth::user()->role_id <> 15)
                    <div class="card bg-gradient-default mt-1 mb-1" style="margin: 0.5rem 0;">
                        <div class="card-body">
                            <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                                <div class="container-fluid">
                                <h2 style = "color: white">Buscador</h2>
                                {{ Form::open(['route' => 'db_empresa_index', 'method' => 'GET', 'class' => 'form-inline float-left']) }}
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('empresa', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Empresa', 'size'=>'45x5', 'style' => 'height: 1.5rem;']) }}
                                        </div>
                                    </div>
                                    <div class="form-group mr-1">
                                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm" href="{{ route('db_empresa_index') }}">
                                            <i class="fas fa-redo fa-lg"></i>
                                        </button>
                                    </div>
                                {{ Form::close() }}

                                </div>
                            </nav>
                        </div>
                    </div>
                    @endif
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
                                <h2 class="mb-0" style="color:white">EMPRESA</h2>
                            </div>
                            @if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 9))
                            <div class="col text-right">
                            <a href="{{ route('db_empresa_create') }}" class="btn btn-sm btn-primary">Nueva Empresa</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Empresa</th>
                                    <th scope="col">Ciudad</th>
                                    <th scope="col">Inscripción</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <form action="{{ route('lote') }}" method="POST">
                                        @csrf
                                @foreach ($dbempresas as $empresa)
                                        <td style="width:20px"><a class="text-white" href="#">{{ $empresa->id}}</a></td>
                                        <td style="width: 130px"><a class="text-white" href="{{ url('/empresa/'.$empresa->id.'/show')}}"><strong>{{ ($empresa->empresa)}}</strong></a>
                                        </td>
                                        <td style="width:20px"><a class="text-white" href="#">{{ $empresa->ciudad}}</a></td>
                                        <td style="width:20px">{{ date('d-m-Y', strtotime($empresa->created_at)) }}</td>
                                        <td style="width:20px"><a class="text-white" href="#">{{ $empresa->user->usuario}}</a></td>
                                        <td class="td-actions text-left">
                                            <a href="{{ url('/empresa/'.$empresa->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>  
                                            <a href="{{ url('/empresa/'.$empresa->id.'/certificado')}}" title="Certificado" rel="tooltip" class="btn btn-success btn-round btn-sm" target="_blank">
                                                <i class="fas fa-file"></i>
                                            </a>                               
                                        </td>
                                    </tr>
                                    @endforeach
                                    </form>
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:2em">
                            {{ $dbempresas->isEmpty() ? 'No hay Empresas disponibles.' : $dbempresas->appends(request()->except('page'))->links() }}
                        </ul>
                        <ul class="pagination justify-content-center" style="margin-top:2em">
                        {{ $dbempresas->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    @include('layouts.footers.auth')
    </div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="prod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title text-center" id="myModalLabel">Productos</h4>
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

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="insp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Inspecciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="#" method="post">
      		{{method_field('patch')}}
      		{{csrf_field()}}
	    <div class="modal-body">
            <div class="row">
                <div class="col-7">
                    <label class="control-label col-sm"for="proveedor_id">Expediente</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="expediente" id="expediente">
                        </div>
                </div>
                <div class="col-2">
                    <label class="control-label col-sm"for="pedido">Empresa</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="empresa" id="empresa">
                        </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <br>
	    </div>
	     
      </form>
    </div>
  </div>
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
