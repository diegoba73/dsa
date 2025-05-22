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
                    {{ Form::open(['route' => 'lab_ensayos_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('codigo', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Código']) }}
                        </div>
                    </div>
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('ensayo', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Ensayo']) }}
                        </div>
                    </div>
                    
                    <div class="form-group mr-1">
                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="form-group mr-1">
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('lab_ensayos_index') }}">
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
                                <h3 class="mb-0" style="color:white">Ensayos</h3>
                            </div>
                            @if (Auth::user()->departamento_id == 1) 
                            <div class="col text-right">
                                <a href="{{ route('lab_ensayos_create') }}" class="btn btn-sm btn-primary">Nuevo Ensayo</a>
                            </div>
                            @endif
                            @if (Auth::user()->id == 2 || Auth::user()->id == 3)
                            <a href="#" class="btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#actualizar_modulo">
                                                    Actualizar Precios
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Ensayo</th>
                                    <th scope="col">Tipo de Ensayo</th>
                                    <th scope="col">Método</th>
                                    <th scope="col">Matriz</th>
                                    <th scope="col">Precio</th>
                                    @if (Auth::user()->departamento_id == 1) 
                                    <th scope="col">Opciones</th>
                                    <th></th>
                                    @else
                                    <th></th>
                                    <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($ensayos as $ensayo)
                                                <tr>
                                                    <td>{{ $ensayo->codigo}}</td>
                                                    <td>{{ str_limit($ensayo->ensayo, 25)}}</td>
                                                    <td>{{ $ensayo->tipo_ensayo}}</td>
                                                    <td>{{ str_limit($ensayo->metodo, 15)}}</td>
                                                    <td>{{ $ensayo->matriz->matriz}}</td>
                                                    <td>{{ $ensayo->costo}}</td>
                                                    @if (Auth::user()->departamento_id == 1) 
                                                    <td class="td-actions text-left">
                                                        <a href="{{ url('/lab/ensayos/'.$ensayo->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>                                
                                                    </td>
                                                    <td>
                                                        <form method="POST" action="{{ route('ensayo.toggle-status', $ensayo) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm {{ $ensayo->activo ? 'btn-danger' : 'btn-success' }}">
                                                                {{ $ensayo->activo ? __('Desactivar') : __('Activar') }}
                                                            </button>
                                                        </form> 
                                                    </td>
                                                    @else
                                                    <td></td>
                                                    <td></td>
                                                    @endif
                                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $ensayos->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
<div class="modal fade bd-example-modal-lg" id="actualizar_modulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="myModalLabel">Actualizar Modulo Nomenclador</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{ route('actualizar_modulo') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
	    <div class="modal-body">
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="valor">Valor</label>
                    <div class="form-group">
                    <input type="input" class="form-control form-control-sm" name="valor" id="valor">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="fecha">Fecha</label>
                    <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="fecha" id="fecha">
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
<script>
function refresh() {
setTimeout(function(){
   window.location.reload();
}, 1000);
}
</script>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush