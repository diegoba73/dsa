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
                            {{ Form::open(['route' => 'lab_reactivos_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
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
                                        {{ Form::text('nombre', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Nombre']) }}
                                    </div>
                                </div>
                                
                                <div class="form-group mr-1">
                                    <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                                    <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="form-group mr-1">
                                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('lab_reactivos_index') }}">
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
                                <h3 class="mb-0" style="color:white">Reactivos</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('imprimir_stock_reactivos') }}" class="btn btn-sm btn-secondary" target="_blank">Listado Stock</a>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('lab_reactivos_create') }}" class="btn btn-sm btn-primary">Nuevo Reactivo</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nombre</th>
                                    @if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 8))
                                    <th class="text-center" scope="col">Areas</th>
                                    @else
                                    @endif
                                    <th scope="col">Stock</th>
                                    <th style="text-align:center;" scope="col">RENPRE</th>
                                    <th scope="col">Nº Pedido/s</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($reactivos as $reactivo)
                                                <tr>
                                                    <td style="width:10px">{{ $reactivo->codigo}}</td>
                                                    <td style="width:20px">{{ $reactivo->nombre}}</td>
                                                    @if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 8))
                                                    <td style="width:5px">
                                                    @if ($reactivo->cromatografia == 1)
                                                    <span class="badge badge-pill badge-info">C</span>
                                                        @else
                                                        <p></p>
                                                    @endif
                                                    @if ($reactivo->quimica == 1)
                                                    <span class="badge badge-pill badge-info">Q</span>
                                                        @else
                                                        <p></p>
                                                    @endif
                                                    @if ($reactivo->ensayo_biologico == 1)
                                                    <span class="badge badge-pill badge-info">EB</span>
                                                        @else
                                                        <p></p>
                                                    @endif
                                                    @if ($reactivo->microbiologia == 1)
                                                    <span class="badge badge-pill badge-info">M</span>
                                                        @else
                                                        <p></p>
                                                    @endif
                                                    </td>
                                                    @else
                                                    @endif
                                                    <td style="width:5px">{{ $reactivo->stock}}</td>
                                                    @if ($reactivo->renpre == 1)
                                                    <td style="width:5px; text-align:center;"><i class="fas fa-check-circle fa-lg text-green"></i></td>
                                                    @else
                                                    <td style="width:5px; text-align:center;"><i class="fas fa-times-circle fa-lg text-red"></i></td>
                                                    @endif
                                                    <td style="width:50px">
                                                    @foreach ($reactivo->pedidos as $pedido)
                                                     Nro: {{ $pedido->nro_pedido }}/Fecha: {{ date('d-m-Y', strtotime($pedido->fecha_pedido)) }} <br>
                                                    @endforeach
                                                    </td>
                                                    <td class="td-actions text-left">
                                                        <a href="{{ url('/lab/reactivos/'.$reactivo->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>  
                                                        <a href="{{ route('reactivo_stock', $reactivo->id) }}" title="Stock" rel="tooltip" class="btn btn-info btn-round btn-sm">
                                                            <i class="fas fa-list"></i>
                                                        </a>                                 
                                                    </td>
                                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $reactivos->appends(request()->except('page'))->links() }}
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