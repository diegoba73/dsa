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
                    {{ Form::open(['route' => 'db_me_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('descripcion', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Descripción']) }}
                        </div>
                    </div>    
                    <div class="form-group mr-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('destino', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Destino']) }}
                        </div>
                    </div>  
                    <div class="form-group mr-2">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('nro_nota_remitida', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Nro Nota Remitida']) }}
                        </div>
                    </div>              
                    <div class="form-group mr-1">
                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="form-group mr-1">
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('db_me_index') }}">
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
                                <h3 class="mb-0" style="color:white">Mesa Entrada</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('db_me_create') }}" class="btn btn-sm btn-primary">Nuevo Ingreso</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                <th>Fecha Ingreso</th>
                                <th>Descripción</th>
                                <th>Destino</th>
                                <th>Nro Nota Remitida</th>
                                <th>Finalizado</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($mesaentradas as $mesaentrada)
                                <tr>
                                    <td style="width:20px">{{ date('d-m-Y', strtotime($mesaentrada->fecha_ingreso)) }}</td>
                                    <td style="width:20px">{{ str_limit($mesaentrada->descripcion, 30)}}</td>
                                    <td style="width:20px">{{ str_limit($mesaentrada->destino, 30)}}</td>
                                    <td style="width:20px">{{ $mesaentrada->nro_nota_remitida}}</td>
                                    <td style="width:20px" class="text-center">
                                    @if ($mesaentrada->finalizado == 1)
                                        <a class="fas fa-check-circle fa-2x text-green"></a>
                                        @elseif ($mesaentrada->finalizado == 0)
                                        <a class="fas fa-times-circle fa-2x text-red" href="{{ route('finalizar', $mesaentrada->id) }}"></a>
                                    @endif
                                    </td>
                                    <td class="td-actions text-left">
                                        <a href="{{ url('/db/mesaentrada/'.$mesaentrada->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round">
                                            <i class="fas fa-edit"></i>
                                        </a>                                 
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $mesaentradas->appends(request()->except('page'))->links() }}
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