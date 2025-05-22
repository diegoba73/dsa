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
                                <h3 class="mb-0" style="color:white">Microorganismo</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('lab_cepario_create') }}" class="btn btn-sm btn-primary">Nuevo Microorganismo</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Número</th>
                                    <th scope="col">Microorganismo</th>
                                    <th scope="col">Medio de Cultivo</th>
                                    <th scope="col">Condiciones</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($microorganismos as $microorganismo)
                                                <tr>
                                                    <td>{{ $microorganismo->numero}}</td>
                                                    <td>{{ $microorganismo->microorganismo}}</td>
                                                    <td>{{ $microorganismo->medio_cultivo}}</td>
                                                    <td>{{ $microorganismo->condiciones}}</td>
                                                    <td class="td-actions text-left">
                                                        <a href="{{ url('/lab/cepario/'.$microorganismo->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round">
                                                            <i class="fas fa-edit"></i>
                                                        </a>   
                                                        <a href="{{ route('cepa', $microorganismo->id) }}" title="Cepario" rel="tooltip" class="btn btn-info btn-round">
                                                            <i class="fas fa-list"></i>
                                                        </a>                               
                                                    </td>
                                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $microorganismos->appends(request()->except('page'))->links() }}
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