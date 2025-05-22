@extends('layouts.app')

@section('content')
{{ Form::hidden('url', URL::full()) }}

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
                        <div class="card bg-gradient-default mt-3 mb-lg-0">
                            <div class="card-body">
                                <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                                    <div class="container-fluid">
                                        <h2 style="color: white">Buscador</h2>
                                        {{ Form::open(['route' => 'facturas_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                        <div class="container text-center">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group d-flex flex-column align-items-start">
                                                        {{ Form::text('numero', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número']) }}
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="chosen-select form-control form-control-md" name="remitente">
                                                            <option disabled selected>Remitente</option>
                                                            @foreach($remitentes as $remitente)
                                                            <option value="{{$remitente->id}}">{{$remitente->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if ((Auth::user()->id == 2) || (Auth::user()->id == 22))
                                                    <div class="form-group mr-2 mb-2">
                                                        <div class="input-group input-group-alternative">
                                                        <select class="chosen-select" name="departamento">
                                                            <option disabled selected>Dpto</option>
                                                            @foreach($departamentos as $departamento)
                                                            <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                                            @endforeach
                                                        </select>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mb-2">
                                                        {{ Form::label('fecha_emision_inicio', 'Fecha de Emisión Inicio', ['class' => 'control-label', 'style' => 'color: white; margin-right: 10px']) }}
                                                        {{ Form::date('fecha_emision_inicio', null, ['class' => 'form-control form-control-sm']) }}
                                                    </div>
                                                    <div class="form-group">
                                                    {{ Form::label('fecha_emision_final', 'Fecha de Emisión Final', ['class' => 'control-label', 'style' => 'color: white; margin-right: 10px']) }}
                                                        {{ Form::date('fecha_emision_final', null, ['class' => 'form-control form-control-sm']) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mb-2">
                                                        {{ Form::label('fecha_pago_inicio', 'Fecha de Pago Inicio', ['class' => 'control-label', 'style' => 'color: white; margin-right: 10px']) }}
                                                        {{ Form::date('fecha_pago_inicio', null, ['class' => 'form-control form-control-sm']) }}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('fecha_pago_final', 'Fecha de Pago Final', ['class' => 'control-label', 'style' => 'color: white; margin-right: 10px']) }}
                                                        {{ Form::date('fecha_pago_final', null, ['class' => 'form-control form-control-sm']) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('facturas_index') }}">
                                                            <i class="fas fa-redo"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
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
    
    <div class="container-fluid mt--8">
        <div class="row mt-3">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-gradient-default border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0" style="color:white">Facturas</h3>
                            </div>
                            <div class="col text-right">
                                
                            </div>
                            <div class="col text-right">
                                @if (((Auth::user()->departamento_id == 1) || (Auth::user()->departamento_id == 5)) && ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 12)))
                                <a href="{{ route('facturasfil.excel') }}" class="btn btn-sm btn-secondary">Listado Facturas en EXCEL</a>
                                @endif
                                <a href="{{ route('facturas_create') }}" class="btn btn-sm btn-primary">Nueva Factura</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                <th>Numero</th>
                                <th>Remitente</th>
                                <th>Fecha Emision</th>
                                <th>Fecha Pago</th>
                                <th>Departamento</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Enlace a pago</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($facturas as $factura)
                                    <tr>
                                        <td>{{ $factura->id }}</td>
                                        <td><a class="text-white" href="{{ url('/lab/facturas/'.$factura->id.'/imprimir_factura')}}" target="_blank">{{ $factura->remitente->nombre }}</a></td>
                                        <td>{{ date('d-m-Y', strtotime($factura->fecha_emision)) }}</td>
                                        <td>@if (strtotime($factura->fecha_pago) > 0) {{ date('d-m-Y', strtotime($factura->fecha_pago)) }} @endif</td>
                                        <td>{{ $factura->departamento->departamento }}</td>
                                        <td>{{ $factura->total }}</td>
                                        <td>
                                            @if ($factura->estado == 'NO PAGADA')
                                                <span class="badge badge-pill badge-danger">{{ $factura->estado }}</span>
                                            @elseif ($factura->estado == 'PAGADA')
                                                <span class="badge badge-pill badge-success">{{ $factura->estado }}</span>
                                            @endif
                                        </td>
                                        <td><a href="{{ url('/lab/facturas/'.$factura->id.'/ver-archivo') }}" target="_blank">{{ $factura->ruta }}</a></td>
                                        <td>
                                        @if ((Auth::user()->departamento_id == 3) || (Auth::user()->departamento_id == 4) || (Auth::user()->id == 2))
                                            <a href="{{ route('facturas_edit', ['id' => $factura->id]) }}" class="btn btn-success btn-round btn-sm">
                                                <i>Editar factura</i>
                                            </a>
                                        @endif
                                            <a href="#" class="btn btn-info btn-round btn-sm" data-fid="{{ $factura->id }}" data-ffechapago="{{ $factura->fecha_pago }}" data-toggle="modal" data-target="#pagof">
                                                <i>Ingresar pago</i>
                                            </a>
                                            <a href="{{ url('/lab/facturas/'.$factura->id.'/delete') }}" onclick="return confirm('¿Está seguro de eliminar la Factura?')" title="Eliminar" rel="tooltip" class="btn btn-danger btn-round btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $facturas->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
<!-- Modal -->
@if(!empty($factura))
<div class="modal fade bd-example-modal-lg" id="pagof" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Ingresar pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{ route('factura.carga_factura', $factura->id) }}" method="post" enctype="multipart/form-data">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
	    <div class="modal-body">
                
        <input type="hidden" class="form-control" name="id" id="id" value="">
        <input type="file" class="form-control" name="factura">
        <input type="input" class="form-control" name="nombre_factura" id="nombre_factura" placeholder="Identificacion" value="{{ $factura->nombre }}">
            
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="fechapago">Fecha Pago</label>
                    <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="fecha_pago" id="fecha_pago" value="{{ $factura->fecha_pago }}">
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
@endif
@if(!empty($factura))
<div class="modal fade bd-example-modal-lg" id="editarf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Editar factura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{ route('factura.update', $factura->id) }}" method="post" enctype="multipart/form-data">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
	    <div class="modal-body">
                
        <input type="hidden" class="form-control" name="id" id="id" value="">
        <input type="file" class="form-control" name="factura">
        <input type="input" class="form-control" name="nombre_factura" id="nombre_factura" placeholder="Identificacion" value="{{ $factura->nombre }}">
            
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="fechapago">Fecha Pago</label>
                    <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="fecha_pago" id="fecha_pago" value="{{ $factura->fecha_pago }}">
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
@endif
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