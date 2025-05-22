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
                    {{ Form::open(['route' => 'db_remitos_index', 'method' => 'GET', 'class' => 'form-inline pull-left']) }}
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('nro_nota', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número de Nota']) }}
                        </div>
                    </div>
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('conclusion', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Conclusión']) }}
                        </div>
                    </div>   
                    <div class="form-group mr-5">
                    <select class="chosen-select" name="remitente">
                                                            <option disabled selected>Remitente</option>
                                                            @foreach($remitentes as $remitente)
                                                            <option value="{{$remitente->id}}">{{$remitente->nombre}}</option>
                                                            @endforeach
                                                        </select>
                    </div>                 
                    <div class="form-group mr-1">
                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="form-group mr-1">
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('db_remitos_index') }}">
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
                                <h3 class="mb-0" style="color:white">Remitos ingresados</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('db_remitos_create') }}" class="btn btn-sm btn-primary">Nueva Remito</a>
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
                                <th>Conclusión</th>
                                <th>Firmado</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($db_remitos as $db_remito)
                                <tr>
                                    <td class="text-center">{{ $db_remito->nro_nota}}</td>
                                                    <td>{{ date('d-m-Y', strtotime($db_remito->fecha)) }}</td>
                                                    <td>{{ $db_remito->remitente->nombre}}</td>
                                                    <td>{{ str_limit($db_remito->conclusion, 30)}}</td>
                                                    <td>
                                                    @if ($db_remito->chequeado == 1)
                                                        <a class="fas fa-check-circle fa-2x text-green"></a>
                                                        @else
                                                        <a class="fas fa-times-circle fa-2x text-red"></a>
                                                    @endif
                                                    </td>
                                                    <td class="td-actions text-left">
                                                        <a href="{{ url('/db/remitos/'.$db_remito->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round">
                                                        <i class="fas fa-edit"></i>
                                                        </a>  
                                                        <a href="{{ url('/db/remitos/'.$db_remito->id.'/imprimir_remito')}}" target="_blank" title="Imprimir Remito" rel="tooltip" class="btn btn-primary btn-round">
                                                        <i class="fas fa-print"></i>
                                                            </a>
                                                        @if ($db_remito->chequeado === 1)
                                                        <a href="{{ url('/db/remitos/'.$db_remito->id.'/imprimir_remito_firma')}}" target="_blank" title="Imprimir Remito con firma" rel="tooltip" class="btn btn-primary btn-round">
                                                            <i class="fas fa-file-signature"></i>
                                                        </a>       
                                                        @else
                                                        <a></a>                        
                                                        @endif
                                                            @if ((Auth::user()->id == 4) || (Auth::user()->id == 3))
                                                            @if (($db_remito->chequeado === null) || ($db_remito->chequeado === 0))
                                                                <a class="btn btn-primary btn-round" href="{{ route('aceptar_remito', $db_remito->id) }}">
                                                                    <i class="fas fa-check"></i>
                                                                </a>
                                                                <a class="btn btn-primary btn-round" href="{{ route('rechazar_remito', $db_remito->id) }}">
                                                                    <i class="fas fa-times"></i>
                                                                </a>
                                                            @elseif ($db_remito->chequeado === 1)
                                                                <a class="btn btn-primary btn-round" href="{{ route('rechazar_remito', $db_remito->id) }}">
                                                                    <i class="fas fa-times"></i>
                                                                </a>
                                                            @endif
                                                            @endif                     
                                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $db_remitos->appends(request()->except('page'))->links() }}
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