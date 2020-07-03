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
                    {{ Form::open(['route' => 'dsa_facturas_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('depositante', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Depositante']) }}
                        </div>
                    </div>  
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::date('fecha', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Fecha Pago']) }}
                        </div>
                    </div>
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('detalle', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Detalle']) }}
                        </div>
                    </div>  
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('departamento', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Departamento']) }}
                        </div>
                    </div>                 
                    <div class="form-group mr-1">
                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="form-group mr-1">
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('dsa_facturas_index') }}">
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
                                <a href="{{ route('dsa_facturas_create') }}" class="btn btn-sm btn-primary">Nueva Factura</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                <th class="text-center">Id</th>
                                <th>Depositante</th>
                                <th>Fecha Emisión</th>
                                <th>Fecha Pago</th>
                                <th>Detalle</th>
                                <th>Departamento</th>
                                <th>Importe</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($facturas as $factura)
                                <tr>
                                    <td class="text-center" style="width:20px">{{ $factura->id}}</td>
                                    <td style="width:20px">{{ $factura->depositante}}</td>
                                    <td style="width:20px">{{ date('d-m-Y', strtotime($factura->fecha_emision)) }}</td>
                                    @if (strtotime($factura->fecha_pago) > 0)
                                                    <td style="width:20%">{{ date('d-m-Y', strtotime($factura->fecha_pago)) }}</td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td style="width:20px">{{ $factura->detalle}}</td>
                                    <td style="width:20px">{{ $factura->departamento}}</td>
                                    <td style="width:20px">{{ $factura->importe}}</td>
                                    <td class="td-actions text-left">
                                        <a href="{{ url('/dsa/facturas/'.$factura->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round">
                                            <i class="fas fa-edit"></i>
                                        </a> 
                                        <a href="{{ url('/dsa/facturas/'.$factura->id.'/delete')}}" onclick="
return confirm('¿Está seguro de eliminar la Factura?')" title="Eliminar" rel="tooltip" class="btn btn-danger btn-round">
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