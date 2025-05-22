@extends('layouts.app')

@section('content')

    <div class="header bg-primary pb-8 pt-5 pt-md-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="content">
                @if (session('notification'))
                    <div class="alert alert-{{ session('alert_type', 'success') }}">
                        {{ session('notification') }}
                    </div>
                @endif              
                <!-- Buscador -->
                <div class="card bg-gradient-default mt-3 mb-2">
                    <div class="card-body">
                        <nav class="navbar navbar-expand-lg navbar-dark" id="navbar-main">
                        <h2 class="text-white mb-4">Buscador</h2> <!-- Agregamos mb-4 para mayor separación -->
                            <div class="container-fluid">
                                
                                {{ Form::open(['route' => 'db_tramites_index', 'method' => 'GET', 'class' => 'form-inline ml-auto']) }}

                                <!-- Número -->
                                <div class="form-group mb-3 mr-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text p-1" style="height: 30px;">
                                                <i class="fas fa-search" style="font-size: 0.85em;"></i>
                                            </span>
                                        </div>
                                        {{ Form::text('numero', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número']) }}
                                    </div>
                                </div>

                                <!-- Empresa y Establecimiento (Solo si role_id != 15) -->
                                @if (Auth::user()->role_id != 15)
                                    <div class="form-group mb-3 mr-3">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text p-1" style="height: 30px;">
                                                    <i class="fas fa-search" style="font-size: 0.85em;"></i>
                                                </span>
                                            </div>
                                            {{ Form::text('empresa', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Empresa', 'style' => 'width: 300px;']) }}
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 mr-3">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text p-1" style="height: 30px;">
                                                    <i class="fas fa-search" style="font-size: 0.85em;"></i>
                                                </span>
                                            </div>
                                            {{ Form::text('establecimiento', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Establecimiento', 'style' => 'width: 300px;']) }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Estado -->
                                <div class="form-group mb-3 mr-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text p-1" style="height: 30px;">
                                                <i class="fas fa-search" style="font-size: 0.85em;"></i>
                                            </span>
                                        </div>
                                        {{ Form::select('estado', [
                                            '' => 'Seleccionar Estado',
                                            'INICIADO' => 'INICIADO',
                                            'EVALUADO POR AREA PROGRAMATICA' => 'EVALUADO POR AREA PROGRAMATICA',
                                            'APROBADO' => 'APROBADO',
                                            'REVISADO POR EMPRESA' => 'REVISADO POR EMPRESA',
                                            'OBSERVADO POR AUTORIDAD SANITARIA' => 'OBSERVADO POR AUTORIDAD SANITARIA',
                                            'DEVUELTO A NC' => 'DEVUELTO A NC',
                                            'DEVUELTO AL AREA PROGRAMATICA' => 'DEVUELTO AL AREA PROGRAMATICA',
                                            'INSCRIPTO' => 'INSCRIPTO',
                                            'MODIFICADO' => 'MODIFICADO',
                                            'FINALIZADO' => 'FINALIZADO',
                                            'BAJA ESTABLECIMIENTO' => 'BAJA ESTABLECIMIENTO',
                                            'PEDIDO DE MODIFICACION' => 'PEDIDO DE MODIFICACION'
                                        ], null, ['class' => 'form-control form-control-sm']) }}
                                    </div>
                                </div>

                                <!-- Zona (Solo para roles 9 y 1) -->
                                @if (Auth::user()->role_id == 9 || Auth::user()->role_id == 1)
                                    <div class="form-group mb-3 mr-3">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text p-1" style="height: 30px;">
                                                    <i class="fas fa-search" style="font-size: 0.85em;"></i>
                                                </span>
                                            </div>
                                            {{ Form::select('zona', [
                                                '' => 'Seleccionar Zona',
                                                'nc' => 'NIVEL CENTRAL',
                                                'apcr' => 'AREA COMODORO',
                                                'appm' => 'AREA PUERTO MADRYN',
                                            ], null, ['class' => 'form-control form-control-sm']) }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Botones -->
                                <div class="form-group d-flex align-items-center mb-3">
                                    <button type="submit" class="btn btn-secondary btn-sm mr-2">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    <a href="{{ route('db_tramites_index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-redo"></i> Resetear
                                    </a>
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
                                <h3 class="mb-0" style="color:white">Tramites</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nro Trámite</th>
                                    <th>Zona</th> <!-- NUEVA COLUMNA -->
                                    <th>Fecha inicio</th>
                                    <th>Tipo Trámite</th>
                                    <th>Establecimiento</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tramites as $tramite)
                                    @php
                                        $user = Auth::user();
                                        $role = $user->role_id;
                                        $estado = strtolower($tramite->estado);
                                        $zona = strtolower(
                                            $tramite->dbredb->localidad->zona 
                                            ?? $tramite->dbrpadb->dbredb->localidad->zona 
                                            ?? ''
                                        );
                                    @endphp
                                    <tr>
                                        <td>{{ $tramite->id }}</td>
                                        <td class="text-uppercase">{{ $zona ?: 'Sin zona' }}</td>
                                        <td>{{ date('d-m-Y', strtotime($tramite->fecha_inicio)) }}</td>
                                        <td>
                                        @php
                                            $tipo = $tramite->tipo_tramite;
                                            $esProductor = $role === 15;
                                            $mostrarLink = true;
                                            $id = null;
                                            $ruta = null;
                                            $estadoNormalizado = strtoupper(trim($tramite->estado));

                                            // Si es un trámite de producto
                                            if ($tramite->dbrpadb && $tramite->dbrpadb->id) {
                                                $id = $tramite->dbrpadb->id;

                                                if ($esProductor && !in_array($estadoNormalizado, ['DEVUELTO', 'OBSERVADO POR AUTORIDAD SANITARIA'])) {
                                                    $mostrarLink = false;
                                                }

                                                if (Str::contains($tipo, 'INSCRIPCION PRODUCTO')) {
                                                    $ruta = route('rpadb.edit_inscripcion', $id) . "?tramite_id={$tramite->id}";
                                                } elseif (Str::contains($tipo, 'MODIFICACION PRODUCTO') || Str::contains($tipo, 'REINSCRIPCION PRODUCTO')) {
                                                    $ruta = route('rpadb.edit_modificacion', $id) . "?tramite_id={$tramite->id}";
                                                } elseif (Str::contains($tipo, 'BAJA PRODUCTO')) {
                                                    if ($estadoNormalizado === 'FINALIZADO') {
                                                        $ruta = route('rpadb.show', $id);
                                                    } elseif ($role === 9) {
                                                        $ruta = route('rpadb.create_baja', $id) . "?tramite_id={$tramite->id}";
                                                    }
                                                }

                                            // Si es un trámite de establecimiento
                                            } elseif ($tramite->dbredb && $tramite->dbredb->id) {
                                                $id = $tramite->dbredb->id;

                                                if ($esProductor && (!in_array($estadoNormalizado, ['DEVUELTO', 'OBSERVADO POR AUTORIDAD SANITARIA']) || Str::contains($tipo, 'BAJA'))) {
                                                    $mostrarLink = false;
                                                }

                                                if (Str::contains($tipo, 'INSCRIPCION ESTABLECIMIENTO')) {
                                                    $ruta = route('db_redb_edit_inscripcion', $id) . "?tramite_id={$tramite->id}";
                                                } elseif (Str::contains($tipo, 'MODIFICACION ESTABLECIMIENTO')) {
                                                    $ruta = route('db_redb_edit_modificacion', $id) . "?tramite_id={$tramite->id}";
                                                } elseif (Str::contains($tipo, 'REINSCRIBIR ESTABLECIMIENTO')) {
                                                    $ruta = route('db_redb_edit_reinscripcion', $id) . "?tramite_id={$tramite->id}";
                                                } elseif (Str::contains($tipo, 'BAJA ESTABLECIMIENTO')) {
                                                    if ($estadoNormalizado === 'FINALIZADO') {
                                                        $ruta = route('db_redb_show', $id);
                                                    } elseif ($role === 9) {
                                                        $ruta = route('db_redb_create_baja', $id) . "?tramite_id={$tramite->id}";
                                                    }
                                                }
                                            }
                                        @endphp

                                        @if ($ruta && $mostrarLink)
                                            <a href="{{ $ruta }}">{{ $tipo }}</a>
                                        @else
                                            {{ $tipo }}
                                        @endif
                                        </td>
                                        <td>{{ $tramite->dbredb->establecimiento ?? $tramite->dbrpadb->dbredb->establecimiento ?? 'Sin establecimiento' }}</td>
                                        <td>
                                            @php
                                                $estadoMayus = strtoupper($tramite->estado);
                                                $badgeInfo = ['EVALUADO POR AREA PROGRAMATICA', 'APROBADO'];
                                                $enProceso = [
                                                    'INICIADO', 'REENVIADO POR EMPRESA', 'DEVUELTO', 'DEVUELTO A AREA',
                                                    'DEVUELTO A NC', 'REVISADO POR EMPRESA', 'OBSERVADO POR AUTORIDAD SANITARIA',
                                                    'PEDIDO DE MODIFICACION'
                                                ];
                                                $finalizado = ['INSCRIPTO', 'REINSCRIPTO', 'MODIFICADO', 'FINALIZADO'];
                                                $rechazado = ['RECHAZADO', 'CANCELADO', 'BAJA ESTABLECIMIENTO', 'BAJA PRODUCTO'];

                                                if (in_array($estadoMayus, $badgeInfo)) {
                                                    $badgeClass = 'badge-info';
                                                } elseif (in_array($estadoMayus, $enProceso)) {
                                                    $badgeClass = 'badge-warning';
                                                } elseif (in_array($estadoMayus, $finalizado)) {
                                                    $badgeClass = 'badge-success';
                                                } elseif (in_array($estadoMayus, $rechazado)) {
                                                    $badgeClass = 'badge-danger';
                                                } else {
                                                    $badgeClass = 'badge-secondary';
                                                }
                                            @endphp
                                            <span class="badge badge-pill {{ $badgeClass }}">
                                                {{ $tramite->estado }}
                                            </span>
                                        </td>
                                        <td class="td-actions text-left">
                                            <form action="{{ route('tramites.destroy', $tramite->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este trámite y sus relaciones?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <ul class="pagination justify-content-center" style="margin-top:1em">
                        {{ $tramites->isEmpty() ? 'No hay tramites disponibles.' : $tramites->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
@foreach($tramites as $tramite)
    <!-- Código para mostrar información del trámite aquí -->

    <!-- Modal -->
    <div class="modal fade" id="historialModal{{ $tramite->id }}" tabindex="-1" role="dialog" aria-labelledby="historialModalLabel{{ $tramite->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historialModalLabel{{ $tramite->id }}">Historial del Trámite</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($tramite->historial->sortByDesc('fecha') as $historial)
                        <div class="row">
                            <div class="col-12">
                                <p><strong>{{ $historial->fecha }} - USUARIO: {{ $historial->user->usuario }}</strong>: {{ $historial->observaciones }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Agrega un evento de clic a los botones con la clase 'detalle-btn'
        $('.detalle-btn').click(function() {
            // Obtén la información específica del botón clicado
            var hid = $(this).data('hid');
            var hobservaciones = $(this).data('hobservaciones');
            
            // Actualiza el contenido del modal con la información específica
            $('#observaciones').val(hobservaciones);

            // Muestra el modal
            $('.modal').modal('show');
        });
    });
</script>