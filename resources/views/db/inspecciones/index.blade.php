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
                    {{ Form::open(['route' => 'db_inspeccion_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('establecimiento', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Establecimiento']) }}
                        </div>
                    </div>             
                    <div class="form-group mr-1">
                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="form-group mr-1">
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('db_inspeccion_index') }}">
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
                                <h3 class="mb-0" style="color:white">Inspecciones</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('db_inspeccion_create') }}" class="btn btn-sm btn-primary">Nueva Inspección</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                <th>Fecha Inspección</th>
                                <th>Establecimiento</th>
                                <th>Motivo</th>
                                <th>Higiene</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($inspecciones as $inspeccion)
                                <tr>
                                    <td style="width:20px">{{ date('d-m-Y', strtotime($inspeccion->fecha)) }}</td>
                                    <td style="width:20px">{{ $inspeccion->establecimiento}}</td>
                                    <td style="width:20px">{{ $inspeccion->motivo}}</td>
                                    <td style="width:20px">{{ $inspeccion->higiene}}</td>
                                    <td class="td-actions text-left">
                                        <a href="{{ url('/inspecciones/'.$inspeccion->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round">
                                            <i class="fas fa-edit"></i>
                                        </a> 
                                        <a href="#" class="btn btn-success btn-round detalle-btn" 
                                        data-srid="{{$inspeccion->id}}" data-srdetalle="{{$inspeccion->detalle}}" data-srfecha="{{$inspeccion->fecha}}" data-srestablecimiento="{{$inspeccion->establecimiento}}"data-target="#detalleModal{{$inspeccion->id}}">
                                        <i class="far fa-eye text-blue"></i>
                                        </a>                   
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $inspecciones->isEmpty() ? 'No hay inspecciones disponibles.' : $inspecciones->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" value= "INSPECCION DE:" readonly style="border: none;" style="text-align: right;"><input type="text" name="establecimiento" id="establecimiento" readonly style="text-align: left; border: none;">
                <br>
                <input type="text" value= "FECHA:" readonly style="border: none;" style="text-align: right;"><input type="text" name="fecha" id="fecha" readonly style="text-align: left; border: none;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <form action="#" method="post">
                {{method_field('patch')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label class="control-label col-sm"for="detalle">Detalle</label>
                            <div class="form-group">
                                <textarea id="detalle" name="detalle" rows="10" cols="80" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <br>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Agrega un evento de clic a los botones con la clase 'detalle-btn'
        $('.detalle-btn').click(function() {
            // Obtén la información específica del botón clicado
            var srid = $(this).data('srid');
            var srdetalle = $(this).data('srdetalle');
            var srfecha = $(this).data('srfecha');
            var srestablecimiento = $(this).data('srestablecimiento');
            
            // Actualiza el contenido del modal con la información específica
            $('#detalle').val(srdetalle);
            $('#fecha').val(srfecha);
            $('#establecimiento').val(srestablecimiento);

            // Muestra el modal
            $('.modal').modal('show');
        });
    });
</script>