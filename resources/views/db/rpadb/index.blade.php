@extends('layouts.app')

@section('content')

<div class="header bg-primary pb-1 pt-5 pt-md-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="content">
                @if (session('notification'))
                    <div class="alert alert-success">
                        {{ session('notification') }}
                    </div>
                @endif
                @if (session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error:</strong> {{ $errors->first() }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <!-- Buscador -->
                <div class="card bg-gradient-default mt-1 mb-1" style="margin: 0.5rem 0;">
                    <div class="card-body">
                        <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                            <div class="container-fluid">
                            <h2 style="color: white">Buscador</h2>
                            {{ Form::open(['route' => 'db_rpadb_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group mr-2 mb-2">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                        </div>
                                        {{ Form::text('numero', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número', 'style' => 'height: 1.5rem;']) }}
                                    </div>
                                </div>
                                <div class="form-group mr-2">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                        </div>
                                        {{ Form::text('producto', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Producto', 'style' => 'height: 1.5rem;']) }}
                                    </div>
                                </div>
                                <div class="form-group mr-1">
                                    <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm" href="{{ route('db_rpadb_index') }}">
                                        <i class="fas fa-redo fa-lg"></i>
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

<div class="container-fluid mt-2">
    <div class="row mt-2">
        <div class="col-xl-12 mb-2 mb-xl-0">
            <div class="card bg-gradient-default shadow">
                <div class="card-header bg-gradient-default border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="mb-0" style="color:white">R.P.A.D.B.</h2>
                        </div>
                        <div class="col text-right">
                            <a href="#" class="btn btn-sm btn-success btn-close" data-toggle="modal" data-target="#">Consultas Registros en EXCEL</a>
                            @if (Auth::user()->role_id == 15)
                            <a href="{{ route('db_rpadb_create_inscripcion') }}" class="btn btn-sm btn-primary">Inscribir Producto</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table table-striped align-items-center table-dark">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Número</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Inscripción</th>
                                <th scope="col">Reinscripción</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rpadbs as $rpadb)
                                @php
                                    $zona = $rpadb->dbredb->localidad->zona ?? null;
                                    if ($rpadb->dbbaja_id || ($rpadb->baja && $rpadb->baja->fecha_baja)) {
                                        $estado = 'BAJA';
                                    } elseif (!$rpadb->finalizado && $rpadb->tramites->where('estado', 'INICIADO')->where('tipo_tramite', 'LIKE', '%MODIFICACION%')->isNotEmpty()) {
                                        $estado = 'PEDIDO DE MODIFICACION';
                                    } elseif ($rpadb->fecha_reinscripcion && $rpadb->fecha_reinscripcion < now()->addMonth()) {
                                        $estado = 'NO VIGENTE';
                                    } else {
                                        $estado = 'ACTIVO';
                                    }
                                @endphp
                            <tr>
                                <td style="width:20px"><a class="text-white" href="#">{{ $rpadb->numero}}</a></td>
                                <td style="width: 130px"><a class="text-white" href="{{ url('/rpadb/'.$rpadb->id.'/show')}}"><strong>{{ str_limit($rpadb->denominacion, 20)}}</strong></a></td>
                                <td style="width:20px"><a class="text-white" href="#">{{ $rpadb->marca}}</a></td>
                                <td style="width:20px">{{ date('d-m-Y', strtotime($rpadb->fecha_inscripcion)) }}</td>
                                <td style="width:20px">{{ date('d-m-Y', strtotime($rpadb->fecha_reinscripcion)) }}</td>
                                <td style="width:20px">
                                    @if ($rpadb->baja && $rpadb->baja->fecha_baja)
                                    <span class="badge badge-pill badge-danger">BAJA: {{ date('d-m-Y', strtotime($rpadb->baja->fecha_baja)) }}</span>
                                    @else
                                    <span class="badge badge-pill badge-success">ACTIVO</span>
                                    @endif
                                </td>
                                <td class="td-actions text-left">
                                    {{-- Botón: Modificar Producto (solo si no está dado de baja) --}}
                                    @if (!$rpadb->baja || !$rpadb->baja->fecha_baja)
                                        @if (Auth::user()->role_id === 15)
                                            <form action="{{ route('rpadb.create_modificacion') }}" method="GET" style="display:inline;">
                                                <input type="hidden" name="rpadb_id" value="{{ $rpadb->id }}">
                                                <button type="submit" class="btn btn-info btn-round btn-sm" title="Modificar">
                                                    Modificar
                                                </button>
                                            </form>
                                        @endif
                                        @if (
                                            Auth::user()->role_id == 15 &&
                                            \Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($rpadb->fecha_reinscripcion)->subMonth()) &&
                                            (!$rpadb->baja || !$rpadb->baja->fecha_baja)
                                        )
                                            <a href="{{ route('rpadb.create_reinscripcion', ['rpadb_id' => $rpadb->id]) }}"
                                            title="Reinscripción"
                                            class="btn btn-warning btn-round btn-sm"
                                            rel="tooltip">
                                                Reinscripción
                                            </a>
                                        @endif
                                        {{-- Botón: Dar de baja (abre modal) --}}

                                        {{-- PRODUCTOR solicita baja si aún no fue iniciada y es zona ≠ NC --}}
                                        @if (Auth::user()->role_id === 15 && $zona !== 'NC' && !$rpadb->tramiteActivo('BAJA PRODUCTO'))
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalBajaProducto{{ $rpadb->id }}">
                                                Solicitar Baja
                                            </button>
                                        @endif

                                        {{-- ÁREA inicia baja si zona ≠ NC y no fue iniciada --}}
                                        @if (in_array(Auth::user()->role_id, [16, 17, 18]) && $zona !== 'NC' && !$rpadb->tramiteActivo('BAJA PRODUCTO'))
                                            <a href="{{ route('rpadb.solicitar_baja', $rpadb->id) }}" class="btn btn-danger btn-sm"
                                                onclick="event.preventDefault(); if(confirm('¿Está seguro que desea iniciar la baja?')) { document.getElementById('formBajaArea{{ $rpadb->id }}').submit(); }">
                                                Iniciar Baja
                                            </a>
                                            <form id="formBajaArea{{ $rpadb->id }}" method="POST" action="{{ route('rpadb.solicitar_baja', $rpadb->id) }}" style="display:none;">
                                                @csrf
                                                <input type="hidden" name="observaciones" value="Trámite de baja iniciado por el área.">
                                            </form>
                                        @endif

                                        {{-- ÁREA evalúa baja si ya existe y está iniciada --}}
                                        @if (in_array(Auth::user()->role_id, [16, 17, 18]) && $zona !== 'NC'
                                            && $rpadb->tramiteActivo('BAJA PRODUCTO') && $rpadb->tramiteActivo('BAJA PRODUCTO')->estado === 'INICIADO')
                                            <form method="POST" action="{{ route('rpadb.evaluar_baja', $rpadb->id) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('¿Evaluar trámite de baja?')">
                                                    Evaluar Baja
                                                </button>
                                            </form>
                                        @endif

                                        {{-- NIVEL CENTRAL aprueba baja si corresponde --}}
                                        @if (Auth::user()->role_id === 9 
                                            && $rpadb->tramiteActivo('BAJA PRODUCTO') 
                                            && in_array($rpadb->tramiteActivo('BAJA PRODUCTO')->estado, ['INICIADO', 'EVALUADO POR AREA PROGRAMATICA']))
                                            <form method="POST" action="{{ route('rpadb.aprobar_baja', $rpadb->id) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Aprobar baja del producto?')">
                                                    Aprobar Baja
                                                </button>
                                            </form>
                                        @endif

                                        {{-- ADMIN accede a registrar la baja si ya fue aprobada --}}
                                        @if (Auth::user()->role_id === 1 
                                            && $rpadb->tramiteActivo('BAJA PRODUCTO') 
                                            && $rpadb->tramiteActivo('BAJA PRODUCTO')->estado === 'APROBADO')
                                            <a href="{{ route('rpadb.create_baja', $rpadb->id) }}" class="btn btn-warning btn-sm" title="Registrar Baja">
                                                Registrar Baja
                                            </a>
                                        @endif
                                    @endif
                                    {{-- Botón: Ver Certificado si no está dado de baja --}}
                                    @if ($estado !== 'BAJA')
                                        <a href="{{ route('certificado', $rpadb->id) }}"
                                        title="Certificado"
                                        rel="tooltip"
                                        class="btn btn-success btn-round btn-sm"
                                        target="_blank">
                                            Certificado
                                        </a>  
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <ul class="pagination justify-content-center" style="margin-top:2em">
                    {{ $rpadbs->isEmpty() ? 'No hay productos disponibles.' : $rpadbs->appends(request()->except('page'))->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>

@include('layouts.footers.auth')
</div>

<!-- Modales de Facturación Adaptados -->
@foreach ($rpadbs as $rpadb)
@if (Auth::user()->role_id === 15 && $rpadb->dbredb->localidad->zona !== 'NC' && !$rpadb->tramiteActivo('BAJA PRODUCTO'))
<div class="modal fade" id="modalBajaProducto{{ $rpadb->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabelBaja{{ $rpadb->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('rpadb.solicitar_baja', $rpadb->id) }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabelBaja{{ $rpadb->id }}">Solicitud de Baja del Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="observaciones">Motivo:</label>
                <textarea name="observaciones" class="form-control" rows="3" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Confirmar Solicitud</button>
          </div>
        </div>
    </form>
  </div>
</div>
@endif

<!-- Modal para Factura de Modificación -->
<div class="modal fade" id="facturaModal{{$rpadb->id}}" tabindex="-1" role="dialog" aria-labelledby="facturaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="facturaModalLabel">Pago para la Modificación del Establecimiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($montoModificacion)
                    <p><strong>Costo de la modificación al Registro Provincial de Establecimientos:</strong> ${{ number_format($montoModificacion, 2) }}</p>
                @else
                    <p><strong>Costo de la modificación al Registro Provincial de Establecimientos:</strong> No disponible</p>
                @endif
                <p><strong>El monto debe ser abonado por TRANSFERENCIA BANCARIA a la siguiente cuenta:</strong></p>
                
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>Cta. Cte. Banco del Chubut</td>
                        </tr>
                        <tr>
                            <td>CBU: 0830021807002242570012</td>
                        </tr>
                        <tr>
                            <td>CUIT: 30-99922146-3</td>
                        </tr>
                        <tr>
                            <td><strong><u>NO MERCADOPAGO, NO RAPIPAGO, NO PAGO FÁCIL</u></strong></td>
                        </tr>
                    </tbody>
                </table>
                
                <p><strong>Una vez abonado guardar el comprobante bancario como archivo PDF, el mismo será solicitado para ser adjuntado en el trámite de modificación y es <u>OBLIGATORIO</u></strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                
                @if ($existeFacturaPendiente)
                    <p class="text-center text-muted">Ya existe una factura pendiente para esta modificación.</p>
                @elseif ($existeTramiteModificacionPendiente)
                <div class="alert alert-danger text-center">
                    <strong>Ya existe un trámite de modificación sin finalizar.</strong>
                </div>
                @else
                    <a href="{{ route('generarFacturaModificacion', ['rpadb_id' => $rpadb->id]) }}" class="btn btn-primary">Continuar Trámite</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
<!-- Script para actualizar el valor de la cantidad en el formulario -->
<script>
document.getElementById('continuarTramiteForm').addEventListener('submit', function(event) {
    event.preventDefault();
    console.log('Formulario enviado');
    // Aquí puedes verificar los datos del formulario
});
</script>

