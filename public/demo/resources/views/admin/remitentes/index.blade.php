@extends('layouts.app')

@section('content')
<div class="header bg-primary pb-8 pt-5 pt-mt-6">
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
                    {{ Form::open(['route' => 'remitentes_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
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
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('remitentes_index') }}">
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
</div>
    
    <div class="container-fluid mt--8">
        <div class="row mt-2">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-gradient-default border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0" style="color:white">Remitentes</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('remitentes_create') }}" class="btn btn-sm btn-primary">Nuevo Remitente</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                <th>Remitente</th>
                                <th>Responsable</th>
                                <th>Localidad</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($remitentes as $remitente)
                                <tr>
                                    <td style="width:20px">{{ $remitente->nombre}}</td>
                                    <td style="width:20px">{{ $remitente->responsable}}</td>
                                    <td style="width:20px">{{ $remitente->localidad->localidad}}</td>
                                    <td class="td-actions text-left">
                                        <a href="{{ url('/admin/remitentes/'.$remitente->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>       
                                        <a href="{{ url('/admin/remitentes/'.$remitente->id.'/delete')}}" onclick="
return confirm('¿Está seguro de eliminar el Remitente?')" title="Eliminar" rel="tooltip" class="btn btn-danger btn-round btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>                           
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $remitentes->appends(request()->except('page'))->links() }}
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