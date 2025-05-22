@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.redb.index', 'title' => __('Sistema DPSA')])

@section('content')

<div class="header bg-primary pb-1 pt-5 pt-md-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="content">
                @if(session('notification'))
                    <div class="alert alert-{{ session('class') }}">
                        {{ session('notification') }}
                    </div>
                @endif
                <!-- Buscador -->
                @if (Auth::user()->role_id <> 15)
                <div class="card bg-gradient-default mt-1 mb-1" style="margin: 0.5rem 0;">
                    <div class="card-body">
                        <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                            <div class="container-fluid">
                                <h2 style="color: white">Buscador</h2>
                                {{ Form::open(['route' => 'db_redb_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                
                                <!-- Número de Registro -->
                                <div class="form-group mr-2 mb-2">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                        </div>
                                        {{ Form::text('numero', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número', 'style' => 'height: 1.5rem;']) }}
                                    </div>
                                </div>

                                <!-- Establecimiento -->
                                <div class="form-group mr-2">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                        </div>
                                        {{ Form::text('establecimiento', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Establecimiento', 'size'=>'45x5', 'style' => 'height: 1.5rem;']) }}
                                    </div>
                                </div>

                                <!-- Filtro por Estado -->
                                <div class="form-group mr-2">
                                    <select class="form-control form-control-sm" name="estado" style="height: 1.5rem;">
                                        <option value="" disabled selected>Seleccionar Estado</option>
                                        <option value="ACTIVO">ACTIVO</option>
                                        <option value="NO VIGENTE">NO VIGENTE</option>
                                        <option value="PEDIDO DE MODIFICACION">PEDIDO DE MODIFICACION</option>
                                        <option value="BAJA">BAJA</option>
                                    </select>
                                </div>

                                <!-- Botón de Búsqueda -->
                                <div class="form-group mr-1">
                                    <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm">
                                        <i class="fas fa-redo fa-lg"></i>
                                    </button>
                                </div>
                                
                                {{ Form::close() }}
                            </div>
                        </nav>
                    </div>
                </div>
                @endif
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
                            <h2 class="mb-0" style="color:white">R.E.D.B.</h2>
                        </div>
                        <div class="col text-right">
                        @if (Auth::user()->role_id <> 15)
                        <a href="#" class="btn btn-sm btn-success btn-close" data-toggle="modal" data-target="#">Consultas Registros en EXCEL</a>
                        @endif
                        @if (Auth::user()->role_id == 15)
                            <a href="{{ route('db_redb_create_inscripcion') }}" class="btn btn-primary btn-round btn-sm" title="Inscripción">
                                Inscribir Establecimiento
                            </a>
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
                                <th scope="col">Establecimiento</th>
                                <th scope="col">Inscripción</th>
                                <th scope="col">Reinscripción</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Tránsito</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @csrf
                        @foreach ($redbs as $redb) 
                            <tr>
                                <td style="width:20px"><a class="text-white" href="#">{{ $redb->numero}}</a></td>
                                <td style="width: 130px"><a class="text-white" href="{{ route('db_redb_show', $redb->id) }}"><strong>{{ str_limit($redb->establecimiento, 20)}}</strong></a>
                                </td>
                                <td style="width:20px">{{ date('d-m-Y', strtotime($redb->fecha_inscripcion)) }}</td>
                                <td style="width:20px">{{ date('d-m-Y', strtotime($redb->fecha_reinscripcion)) }}</td>
                                <td style="width:20px">
                                     @if ($redb->dbbaja_id != 0 || $redb->dbbaja_id != null)
                                         <!-- Si el establecimiento está de baja, mostrar siempre este estado como prioridad -->
                                         @php $estado = 'BAJA'; @endphp
                                         <span class="badge badge-pill badge-danger">BAJA</span>
                                     
                                     @elseif (!$redb->finalizado && $redb->dbtramites->where('estado', 'INICIADO')->filter(function ($tramite) {
                                         return Str::contains($tramite->tipo_tramite, 'MODIFICACION');
                                     })->isNotEmpty())
                                         <!-- Si hay un pedido de modificación en estado "INICIADO" -->
                                         @php $estado = 'PEDIDO DE MODIFICACION'; @endphp
                                         <span class="badge badge-pill badge-warning">PEDIDO DE MODIFICACION</span>
                                     
                                     @elseif ($redb->fecha_reinscripcion && $redb->fecha_reinscripcion < now()->addMonth())
                                         <!-- Si la fecha de reinscripción es menor a un mes de la fecha actual y no está de baja -->
                                         @php $estado = 'NO VIGENTE'; @endphp
                                         <span class="badge badge-pill badge-secondary">NO VIGENTE</span>
                                     
                                     @else
                                         <!-- Si el establecimiento está activo -->
                                         @php $estado = 'ACTIVO'; @endphp
                                         <span class="badge badge-pill badge-success">ACTIVO</span>
                                     @endif
                                 </td>
                                <td style="width:20px"><a class="badge badge-pill badge-success">{{ $redb->transito}}</a></td>
                                <td class="td-actions text-left">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#inspeccionesModal{{ $redb->id }}">
                                        Inspecciones
                                    </button>   
                                    @if (Auth::user()->role_id == 15 && !($redb->baja && $redb->baja->fecha_baja))
                                        <form action="{{ route('redb.create_modificacion', ['id' => $redb->id]) }}" method="GET" style="display:inline;">
                                            <input type="hidden" name="redb_id" value="{{ $redb->id }}">
                                            <button type="submit" class="btn btn-primary btn-round btn-sm" title="Modificar">
                                                Modificar
                                            </button>
                                        </form>
                                    @endif
                                    @if (Auth::user()->role_id == 9 && $estado !== 'BAJA' )
                                    <a href="{{ route('db_redb_create_baja', ['redb_id' => $redb->id]) }}" title="Baja" rel="tooltip" class="btn btn-danger btn-round btn-sm">
                                        Baja
                                    </a>        
                                    @endif
                                    @if (Auth::user()->role_id == 15 && \Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($redb->fecha_reinscripcion)->subMonth()) && !($redb->baja && $redb->baja->fecha_baja))
                                        <a href="#modalReinscripcion{{ $redb->id }}" data-toggle="modal" title="Reinscripción" rel="tooltip" class="btn btn-warning btn-round btn-sm">Reinscripción</a>
                                    @endif
                                    @if ($estado !== 'BAJA' && $redb->finalizado == 1)
                                    <a href="{{ url('/redb/'.$redb->id.'/certificado')}}" title="Certificado" rel="tooltip" class="btn btn-success btn-round btn-sm" target="_blank">
                                        Certificado
                                    </a>          
                                    @endif
                                    @if (in_array(Auth::user()->role_id, [15, 16, 17, 18]) && !($redb->dbbaja_id || ($redb->baja && $redb->baja->fecha_baja)))
                                        <button type="button" class="btn btn-danger btn-round btn-sm" data-toggle="modal" data-target="#modalBaja{{ $redb->id }}">
                                            Solicitar Baja
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <ul class="pagination justify-content-center" style="margin-top:2em">
                    {{ $redbs->isEmpty() ? 'No hay establecimientos disponibles.' : $redbs->appends(request()->except('page'))->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>

@include('layouts.footers.auth')
</div>

<!-- Modal para productos -->
<div class="modal fade bd-example-modal-lg" id="prod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title text-center" id="myModalLabel">Productos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <form action="#" method="post">
      		{{method_field('patch')}}
      		{{csrf_field()}}
	      <div class="modal-body">
            <div class="row">
                <div class="col-7">
                    <label class="control-label col-sm"for="proveedor_id">fecha</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="fecha_baja" id="fecha_baja">
                        </div>
                </div>
                <div class="col-2">
                    <label class="control-label col-sm"for="pedido">rubro</label>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="rubro" id="rubro">
                        </div>
                </div>
            </div>
                </div>
                <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <br>
	      </div>
	      </div>
	     
      </form>
    </div>
  </div>
</div>

<!-- Modal para Factura de Inscripción -->
<div class="modal fade" id="modalInscripcion" tabindex="-1" role="dialog" aria-labelledby="modalInscripcionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalInscripcionLabel">Pago para la Inscripción del Establecimiento</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($montoInscripcion)
                    <h1><strong>Costo de la inscripción al Registro Provincial de Establecimientos:<u><span style="color: red;">${{ number_format($montoInscripcion, 2) }}</span></u></strong></h1>
                @else
                    <p><strong>Costo de la inscripción al Registro Provincial de Establecimientos:</strong> No disponible</p>
                @endif
                <h1><strong>El ticket del tramite solicitado será enviado a el correo delcarado oficialmente para los tramites de la Empresa para su depòsito.</strong></h1>
                <h1><strong>El monto debe ser abonado por TRANSFERENCIA BANCARIA a la siguiente cuenta: CBU: 0830021807002242570012, CUIT: 30-99922146-3 (NO REALIZARLA POR MERCADOPAGO, RAPIPAGO o PAGOFÁCIL)</strong></h1>
                <h1><strong>Una vez abonado guardar el comprobante bancario como archivo PDF, el mismo será solicitado para ser adjuntado en el tramite de inscripción y es <u>OBLIGATORIO</u></strong></h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a href="{{ route('generarFacturaInscripcion', ['tipo' => 'Inscripcion']) }}" class="btn btn-primary">Continuar trámite</a>
            </div>
        </div>
    </div>
</div>
@foreach ($redbs as $redb)
<!-- Modales para inspecciones -->
<div class="modal fade" id="inspeccionesModal{{ $redb->id }}" tabindex="-1" role="dialog" aria-labelledby="inspeccionesModalLabel{{ $redb->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inspeccionesModalLabel{{ $redb->id }}">Inspecciones de {{ $redb->establecimiento }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            @if($redb->inspecciones && $redb->inspecciones->count() > 0)
                @foreach($redb->inspecciones->sortByDesc('fecha') as $inspeccion)
                    @if($inspeccion && $inspeccion->dbredb_id)
                        {{-- Código para mostrar los detalles de cada inspección --}}
                        <div>
                            <p>Fecha de inspección: {{ $inspeccion->fecha }} / Detalle: {{ $inspeccion->detalle }}</p>
                        </div>
                    @else
                        {{-- Puedes manejar el caso de datos faltantes o mostrar un mensaje --}}
                        <p>Inspección no asociada correctamente o datos faltantes.</p>
                    @endif
                @endforeach
            @else
                <p>No hay inspecciones registradas para este REDB.</p>
            @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de confirmación para la baja -->
<div class="modal fade" id="modalBaja{{ $redb->id }}" tabindex="-1" role="dialog" aria-labelledby="modalBajaLabel{{ $redb->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBajaLabel{{ $redb->id }}">Solicitar Baja del Establecimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('solicitar_baja', $redb->id) }}">
        @csrf
        <div class="modal-body">
          <!-- Campo oculto para el redb_id (opcional en este caso, ya que el id está en la ruta) -->
          <input type="hidden" name="redb_id" value="{{ $redb->id }}">
          
          <div class="form-group">
            <label for="observaciones{{ $redb->id }}">Descripción:</label>
            <textarea name="observaciones" id="observaciones{{ $redb->id }}" class="form-control" rows="4" placeholder="Ingresa el motivo de la baja" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Pedir Baja</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal para Factura de Modificación -->
<div class="modal fade" id="facturaModal{{$redb->id}}" tabindex="-1" role="dialog" aria-labelledby="facturaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="facturaModalLabel">Pago para la Modificación del Establecimiento</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($montoModificacion)
                    <h1><strong>Costo de la modificación al Registro Provincial de Establecimientos:<u><span style="color: red;">${{ number_format($montoModificacion, 2) }}</span></u></strong></h1>
                @else
                    <p><strong>Costo de la inscripción al Registro Provincial de Establecimientos:</strong> No disponible</p>
                @endif
                <h1><strong>El ticket del tramite solicitado será enviado a el correo delcarado oficialmente para los tramites de la Empresa para su depòsito.</strong></h1>
                <h1><strong>El monto debe ser abonado por TRANSFERENCIA BANCARIA a la siguiente cuenta: CBU: 0830021807002242570012, CUIT: 30-99922146-3 (NO REALIZARLA POR MERCADOPAGO, RAPIPAGO o PAGOFÁCIL)</strong></h1>
                <h1><strong>Una vez abonado guardar el comprobante bancario como archivo PDF, el mismo será solicitado para ser adjuntado en el tramite de inscripción y es <u>OBLIGATORIO</u></strong></h1>
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
                    <a href="{{ route('generarFacturaModificacion', ['redb_id' => $redb->id, 'tipo' => 'Modificación R.E.D.B.']) }}" class="btn btn-primary">Continuar Trámite</a>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Modal para Factura de Reinscripción -->
<div class="modal fade" id="modalReinscripcion{{ $redb->id }}" tabindex="-1" role="dialog" aria-labelledby="modalReinscripcionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalReinscripcionLabel">Pago para la Reinscripción del Establecimiento</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($montoReinscripcion)
                    <h1><strong>Costo de la reinscripción al Registro Provincial de Establecimientos:<u><span style="color: red;">${{ number_format($montoReinscripcion, 2) }}</span></u></strong></h1>
                @else
                    <p><strong>Costo de la inscripción al Registro Provincial de Establecimientos:</strong> No disponible</p>
                @endif
                <h1><strong>El ticket del tramite solicitado será enviado a el correo delcarado oficialmente para los tramites de la Empresa para su depòsito.</strong></h1>
                <h1><strong>El monto debe ser abonado por TRANSFERENCIA BANCARIA a la siguiente cuenta: CBU: 0830021807002242570012, CUIT: 30-99922146-3 (NO REALIZARLA POR MERCADOPAGO, RAPIPAGO o PAGOFÁCIL)</strong></h1>
                <h1><strong>Una vez abonado guardar el comprobante bancario como archivo PDF, el mismo será solicitado para ser adjuntado en el tramite de inscripción y es <u>OBLIGATORIO</u></strong></h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                @if (!$existeFacturaPendiente)
                <a href="{{ route('generarFacturaReinscripcion', ['redb_id' => $redb->id, 'tipo' => 'Reinscripción Registro Provincial de Establecimiento']) }}" class="btn btn-primary">Continuar Trámite</a>
                @else
                    <p class="text-center text-muted">Ya existe una factura pendiente para esta reinscripción.</p>
                    <a href="{{ route('generarFacturaReinscripcion', ['id' => $redb->id, 'tipo' => 'reinscripcion']) }}" class="btn btn-primary">Ir a Reinscripción</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
