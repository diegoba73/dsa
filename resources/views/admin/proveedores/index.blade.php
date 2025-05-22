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
                                <h3 class="mb-0" style="color:white">Proveedores</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('proveedores_create') }}" class="btn btn-sm btn-primary">Nuevo Proveedor</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                <th>Proveedor</th>
                                <th>Contacto</th>
                                <th>Teléfono</th>
                                <th>E-mail</th>
                                <th>Insumos</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($proveedors as $proveedor)
                                <tr>
                                    <td>{{ $proveedor->empresa}}</td>
                                    <td>{{ $proveedor->contacto}}</td>
                                    <td>{{ $proveedor->telefono}}</td>
                                    <td>{{ $proveedor->email}}</td>
                                    <td>{{ $proveedor->tipo_insumo}}</td>
                                    <td class="td-actions text-left">
                                        <a href="{{ url('/admin/proveedores/'.$proveedor->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round">
                                            <i class="fas fa-edit"></i>
                                        </a>                                 
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $proveedors->appends(request()->except('page'))->links() }}
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