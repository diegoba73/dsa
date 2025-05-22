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
                    <div class="card bg-gradient-default mt-3 mb-2 mb-lg-0">
                        <div class="card-body">
                        <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                            <div class="container-fluid">
                                <h2 style = "color: white">Buscador</h2>
                                {{ Form::open(['route' => 'facturas_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group mr-5">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                                        </div>
                                        {{ Form::text('numero', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número']) }}
                                    </div>
                                </div>  
                                <div class="form-group mr-5">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                                        </div>
                                        {{ Form::text('remitente', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Remitente']) }}
                                    </div>
                                </div>                 
                                <div class="form-group mr-1">
                                    <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                                    <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="form-group mr-1">
                                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('facturas_index') }}">
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
                                <h3 class="mb-0" style="color:white">Facturas</h3>
                            </div>
                            <div class="col text-right">
                                
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('facturas.excel') }}" class="btn btn-sm btn-secondary">Listado Facturas en EXCEL</a>
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
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($facturas as $factura)
                                <tr>
                                    <td class="text-center" style="width:20px">{{ $factura->id}}</td>
                                    <td style="width:20px"><a class="text-white" href="{{ url('/lab/facturas/'.$factura->id.'/imprimir_factura')}}" target="_blank">{{ $factura->remitente->nombre }}</a></td>
                                    <td style="width:20px">{{ date('d-m-Y', strtotime($factura->fecha_emision)) }}</td>
                                    @if (strtotime($factura->fecha_pago) > 0)
                                        <td style="width:20%">{{ date('d-m-Y', strtotime($factura->fecha_pago)) }}</td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td style="width:20px">{{ $factura->user->departamento->departamento }}</td>
                                    <td style="width:20px">{{ $factura->total}}</td>
                                    @if($factura->estado == 'NO PAGADA') 
                                                            <td><span class="badge badge-pill badge-danger">{!! $factura->estado !!}</span></td>
                                                        @elseif($factura->estado == 'PAGADA') 
                                                            <td><span class="badge badge-pill badge-success">{!! $factura->estado!!}</span></td>
                                                        @endif>
                                    <td class="td-actions text-left">
                                    <a href="#" class="btn btn-success btn-round btn-sm" data-fid="{{$factura->id}}" data-ffecha_pago="{{$factura->fecha_pago}}" data-fnombre="{{$factura->nombre}}" data-fruta="{{$factura->ruta}}" data-toggle="modal" data-target="#editarf">
                                            <i class="fas fa-edit"></i>
                                        </a> 
                                        <a href="{{ url('/lab/facturas/'.$factura->id.'/delete')}}" onclick="
                                            return confirm('¿Está seguro de eliminar la Factura?')" title="Eliminar" rel="tooltip" class="btn btn-danger btn-round btn-sm">
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
    </div>
<!-- Modal -->

<!-- <div class="modal fade bd-example-modal-lg" id="editarf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Ingresar pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="{{ route('factura.update', $factura->id) }}" method="post">
      		{{method_field('patch')}}
      		{{csrf_field()}}
              @method('PUT')
	    <div class="modal-body">
                
                <input type="hidden" class="form-control" name="id" id="id" value="">
            
            <div class="row">
                <div class="col-3">
                <label class="control-label col-sm"for="fechapago">Fecha Pago</label>
                    <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="fecha_pago" id="fecha_pago">
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
</div> -->
<!-- Modal -->
@if(!empty($factura))
<div class="modal fade bd-example-modal-lg" id="editarf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" style="max-width: 900px;" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Ingresar pago: <span id="myModalLabel"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="{{ route('subir_pago', ['id' => $factura->id]) }}" method="post" enctype="multipart/form-data">

               @csrf
               <input type="hidden" name="_method" value="post">
               <input type="hidden" id="modal-factura-id" name="id" value="{{ $factura->id }}">
               <input type="file" name="factura" class="btn btn-primary">
               <input type="text" name="nombre_factura" class="placeholder col-4" placeholder="Identificación de la factura" value="{{ $factura->nombre }}">
               <!-- Otros campos del formulario si los tienes -->
               <button type="submit" class="btn btn-success">Subir archivo</button>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
         </div>
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