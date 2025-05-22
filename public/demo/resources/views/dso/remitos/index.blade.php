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
                    <h2 style = "color: white">Busqueda de remitos</h2>
                    {{ Form::open(['route' => 'dso_remitos_index', 'method' => 'GET', 'class' => 'form-inline pull-left']) }}
                    <div class="form-group mr-2">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('nro_nota', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número de Nota']) }}
                        </div>
                    </div>  
                    <div class="form-group mr-2">
                    <select class="chosen-select" name="remitente">
                                                            <option disabled selected>Remitente</option>
                                                            @foreach($remitentes as $remitente)
                                                            <option value="{{$remitente->id}}">{{$remitente->nombre}}</option>
                                                            @endforeach
                                                        </select>
                    </div>              
                    <div class="form-group mr-1">
                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm">
                        <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                    <div class="form-group mr-1">
                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm" href="{{ route('lab_reactivos_index') }}">
                        <i class="fas fa-redo fa-sm"></i>
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
                                <h3 class="mb-0" style="color:white">Remitos ingresados</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('dso_remitos_create') }}" class="btn btn-sm btn-primary">Nuevo Remito</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                <th class="text-center">Nro Nota</th>
                                <th>Fecha</th>
                                <th>Remitente</th>
                                <th>Fecha Salida</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($dso_remitos as $dso_remito)
                                <tr>
                                    <td class="text-center">{{ $dso_remito->nro_nota}}</td>
                                                    <td>{{ date('d-m-Y', strtotime($dso_remito->fecha)) }}</td>
                                                    <td>{{ $dso_remito->remitente->nombre}}</td>                                                    @if (strtotime($dso_remito->fecha_salida) > 0)
                                                    <td style="width:20%">{{ date('d-m-Y', strtotime($dso_remito->fecha_salida)) }}</td>
                                                    @else
                                                    <td></td>
                                                    @endif
                                                    <td class="td-actions text-left">
                                                        <a href="{{ url('/dso/remitos/'.$dso_remito->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round">
                                                        <i class="fas fa-edit"></i>
                                                        </a>  
                                                        <a href="{{ url('/dso/remitos/'.$dso_remito->id.'/imprimir_remito')}}" target="_blank" title="Imprimir Remito" rel="tooltip" class="btn btn-primary btn-round">
                                                            <i class="fas fa-print"></i>
                                                        </a>  
                                                        @if (Auth::user()->role_id == 1)
                                                            <a href="{{ url('/dso/remitos/'.$dso_remito->id.'/imprimir_remito_firma')}}" target="_blank" title="Imprimir Remito con firma" rel="tooltip" class="btn btn-primary btn-round">
                                                                <i class="fas fa-file-signature"></i>
                                                            </a>       
                                                        @else
                                                            <a></a>                        
                                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $dso_remitos->appends(request()->except('page'))->links() }}
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