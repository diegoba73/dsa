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
                    {{ Form::open(['route' => 'pedido_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                    <div class="form-group mr-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('nro_pedido', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número de pedido', 'style' => 'height: 1.5rem;']) }}
                        </div>
                    </div>
                    <div class="form-group mr-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('descripcion', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Descripción', 'style' => 'height: 1.5rem;']) }}
                        </div>
                    </div>
                    <div class="form-group mr-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('nro_nota', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Nro Nota', 'style' => 'height: 1.5rem;']) }}
                        </div>
                    </div>
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 12)
                    <div class="form-group mr-3">
                        <div class="input-group input-group-alternative">
                            <select class="chosen-select" name="dpto">
                                <option disabled selected>Departamento</option>
                                @foreach($dptos as $dpto)
                                <option value="{{$dpto->id}}">{{$dpto->departamento}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mr-3">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('nro_expediente', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Nro Expediente', 'style' => 'height: 1.5rem;']) }}
                        </div>
                    </div>
                    @else
                    @endif
                    <div class="form-group mr-1">
                    <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="form-group mr-1">
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm" href="{{ route('pedido_index') }}">
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
                                <h3 class="mb-0" style="color:white">Pedidos</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('pedido_create') }}" class="btn btn-sm btn-primary">Nuevo Pedido</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nro</th>
                                    <th scope="col">Inicio</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Fecha inicio</th>
                                    <th scope="col">Fecha expediente</th>
                                    <th scope="col">Nro Exp.</th>
                                    <th scope="col">Finalizado</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($pedidos as $pedido)
                                                <tr>
                                                    <td><a class="text-white" href="{{ url('/dsa/pedidos/'.$pedido->id.'/show')}}">{{ $pedido->nro_pedido}}</td>
                                                    <td><a class="text-white" href="{{ url('/dsa/pedidos/'.$pedido->id.'/show')}}">{{ $pedido->user->usuario }}</td>
                                                    <td><a class="text-white" href="{{ url('/dsa/pedidos/'.$pedido->id.'/show')}}">{{ str_limit($pedido->descripcion, 30)}}</td>
                                                    <td>
                                                        <a class="text-white" href="{{ url('/dsa/pedidos/'.$pedido->id.'/show')}}" 
                                                        @if($pedido->estado == 'BAJA') 
                                                            <td><span class="badge badge-pill badge-danger">{!! $pedido->estado !!}</span></td>
                                                        @elseif($pedido->estado == 'INICIO') 
                                                            <td><span class="badge badge-pill badge-info">{!! $pedido->estado!!}</span></td>
                                                        @elseif($pedido->estado == 'ADJUDICACION') 
                                                            <td><span class="badge badge-pill badge-warning">{!! $pedido->estado!!}</span></td>
                                                        @elseif($pedido->estado == 'ENTREGA PARCIAL' || $pedido->estado == 'ENTREGA TOTAL') 
                                                            <td><span class="badge badge-pill badge-success">{!! $pedido->estado!!}</span></td>
                                                        @else
                                                            <td><span class="badge badge-pill badge-secondary">{!! $pedido->estado!!}</span></td>
                                                        @endif>
                                                        </a>
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($pedido->fecha_pedido)) }}</td>
                                                    @if (strtotime($pedido->fecha_expediente) > 0)
                                                    <td>{{ date('d-m-Y', strtotime($pedido->fecha_expediente)) }}</td>
                                                    @else
                                                    <td><span class="badge badge-pill badge-warning">SIN EXPEDIENTE</span></td>
                                                    @endif
                                                    <td>{{ $pedido->nro_expediente}}</td>
                                                    @if ($pedido->finalizado == 1)
                                                    <td><span class="fas fa-check fa-2x text-green"></span></td>
                                                    @else
                                                    <td><span class="fas fa-times fa-2x text-red"></span></td>
                                                    @endif
                                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $pedidos->appends(request()->except('page'))->links() }}
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