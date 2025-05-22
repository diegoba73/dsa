@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.rpadb.edit', 'title' => __('Sistema DPSA')])

@section('content')
{{ Form::hidden('url', URL::full()) }}
<input type="hidden" name="tramite_id" value="{{ $tramite->id }}">

@php
    $modoEdicion = Auth::user()->role_id === 15;
    $zona = $rpadb->dbredb->localidad->zona ?? null;
    $mostrarCampoObservaciones = false;
    // PRODUCTOR puede reenviar si está DEVUELTO
    if (Auth::user()->role_id === 15 && $tramite->estado === 'DEVUELTO') {
        $mostrarCampoObservaciones = true;
    }

    // EVALUADORES DE ÁREA con trámite en ciertos estados
    if (in_array(Auth::user()->role_id, [16, 17, 18]) && in_array($tramite->estado, ['INICIADO', 'REENVIADO POR EMPRESA', 'DEVUELTO A AREA']) && in_array($zona, ['appm', 'ape', 'apcr'])) {
        $mostrarCampoObservaciones = true;
    }

    // NIVEL CENTRAL con distintos estados
    if (Auth::user()->role_id === 9 && (
        ($tramite->estado === 'INICIADO' && $zona === 'nc') ||
        $tramite->estado === 'EVALUADO POR AREA PROGRAMATICA' ||
        ($tramite->estado === 'REENVIADO POR EMPRESA' && $zona === 'nc') ||
        $tramite->estado === 'DEVUELTO A NC'
        )) {
        $mostrarCampoObservaciones = true;
    }


    // ADMIN: puede agregar observaciones si va a devolver o inscribir
    if (Auth::user()->role_id === 1 && $tramite->estado === 'APROBADO') {
        $mostrarCampoObservaciones = true;
    }
@endphp

<div class="header bg-primary pb-8 pt-5 pt-md-6">
    <div class="container-fluid">
        <div class="card-body">
            @if (session('notification'))
                <div class="alert alert-success">{{ session('notification') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>@foreach ($errors->all() as $error) <li>{{$error}}</li> @endforeach</ul>
                </div>
            @endif
        </div>
    </div>

    <div class="content bg-primary">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header bg-default">
                            <h4 class="card-title font-weight-bold mb-0 text-white">
                                Actualizando Registro R.P.A.D.B. {{ $rpadb->establecimiento }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('rpadb.update_inscripcion', ['rpadbId' => $rpadb->id, 'tramiteId' => $tramite->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <h2 class="text-primary font-weight-bold mt-4">Datos del Producto</h2>
                                <hr>
                                <div id="productos">
                                    <div class="producto-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Denominación:</label>
                                                    <input type="text" class="form-control" name="denominacion" value="{{ $rpadb->denominacion }}" {{ $modoEdicion ? '' : 'readonly' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Nombre Fantasía:</label>
                                                    <input type="text" class="form-control" name="nombre_fantasia" value="{{ $rpadb->nombre_fantasia }}" {{ $modoEdicion ? '' : 'readonly' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Marca:</label>
                                                    <input type="text" class="form-control" name="marca" value="{{ $rpadb->marca }}" {{ $modoEdicion ? '' : 'readonly' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Establecimiento relacionado:</label>
                                                    <select class="form-control" name="productos[0][selected_item_id]" {{ $modoEdicion ? '' : 'disabled' }}>
                                                        <option value="">-- Seleccionar --</option>
                                                        @foreach($redbs as $redb)
                                                            <option value="{{ $redb->id }}" {{ $rpadb->dbredb_id == $redb->id ? 'selected' : '' }}>
                                                                {{ $redb->establecimiento }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @if (Auth::user()->role_id !== 15)
                                            <h2 class="text-primary font-weight-bold mt-4">Rubro y Artículo del CAA</h2>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Rubro según establecimiento fabricante:</label>
                                                        <select name="dbredb_dbrubro_id" class="form-control">
                                                            <option value="">-- Seleccionar rubro --</option>
                                                            @foreach ($rubros as $rubro)
                                                                @php
                                                                    $categoriaNombre = $categorias[$rubro->pivot->dbcategoria_id]->categoria ?? 'Sin categoría';
                                                                    $actividad = $rubro->pivot->actividad ?? 'Sin actividad';
                                                                @endphp
                                                                <option value="{{ $rubro->pivot->id }}"
                                                                    {{ $rpadb->dbredb_dbrubro_id == $rubro->pivot->id ? 'selected' : '' }}>
                                                                    {{ $rubro->rubro }} (Categoría: {{ $categoriaNombre }} - Actividad: {{ $actividad }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="form-text text-muted">Solo se listan rubros habilitados por el establecimiento fabricante.</small>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Nº Artículo del CAA:</label>
                                                        <input type="text" class="form-control" name="articulo_caa" value="{{ $rpadb->articulo_caa }}">
                                                        <small class="form-text text-muted">Por ejemplo: Art. 128 tris.</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <h2 class="text-primary font-weight-bold mt-4">Envases</h2>
                                <hr>
                                @include('db.rpadb.partials.envases', ['modoEdicion' => $modoEdicion])

                                <h2 class="text-primary font-weight-bold mt-4">Documentación Adjunta</h2>
                                <hr>
                                @include('db.rpadb.partials.documentacion', ['modoEdicion' => $modoEdicion])

                                <h2 class="text-primary font-weight-bold mt-4">Observaciones</h2>
                                <hr>
                                {{-- HISTORIAL DE OBSERVACIONES COMO CHAT --}}
                                <div class="card mt-4">
                                    <div class="card-header bg-gradient-info text-white">
                                        <strong>Conversación / Observaciones</strong>
                                    </div>
                                    <div class="card-body" style="max-height: 350px; overflow-y: auto; background-color: #f4f4f4;">
                                        @forelse ($historiales as $histo)
                                            @php
                                                $esProductor = $histo->area === 'PRODUCTOR';
                                                $alineacion = $esProductor ? 'text-left' : 'text-right';
                                                $colorBurbuja = $esProductor ? 'bg-white' : 'bg-success text-white';
                                                $margen = $esProductor ? 'mr-auto' : 'ml-auto';
                                                $usuario = $histo->user->usuario ?? 'Usuario';
                                            @endphp

                                            <div class="d-flex flex-column {{ $margen }} mb-3" style="max-width: 50%; word-wrap: break-word;">
                                                <div class="small text-muted {{ $alineacion }}">
                                                    {{ $usuario }} — {{ \Carbon\Carbon::parse($histo->fecha)->format('d/m/Y H:i') }}
                                                </div>
                                                <div class="p-2 rounded shadow-sm {{ $colorBurbuja }}">
                                                    {{ $histo->observaciones }}
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted">No hay observaciones aún.</p>
                                        @endforelse
                                    </div>
                                </div>

                                {{-- AGREGAR NUEVA OBSERVACIÓN --}}
                                @if ($mostrarCampoObservaciones)
                                    <div class="form-group mt-3">
                                        <label for="observaciones">Agregar nueva observación:</label>
                                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Escriba una nueva observación..." required>{{ old('observaciones') }}</textarea>
                                        @error('observaciones')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endif

                                @if (Auth::user()->role_id === 1 && $tramite->estado === 'APROBADO')
                                    <div class="row align-items-center p-1">
                                        <div class="col-md-6">
                                            <label class="bmd-label-floating">Expediente:</label>
                                            <input type="text" class="form-control form-control-sm"
                                                    name="expediente"
                                                    value="{{ $tramite->dbexp->numero ?? '' }}"
                                                    {{ (Auth::user()->role_id !== 1 || $tramite->estado !== 'APROBADO') ? 'readonly' : '' }}>
                                            <small class="form-text text-danger">* Requerido.</small>
                                        </div>
                                        <div class="col-md-4 p-1">
                                            <a href="#agregarexp" data-toggle="modal" title="Nº Expediente" class="btn btn-sm btn-success btn-close m-2">Nº Expediente</a>
                                        </div>
                                    </div>
                                @endif

                                <input type="hidden" name="submitType" id="submitType" value="">

                                <div class="text-center mt-4">
                                    <a class="btn btn-default" href="{{ URL::previous() }}">Cancelar</a>

                                    @if (Auth::user()->role_id === 15 && $tramite->estado === 'DEVUELTO')
                                        <button type="submit" class="btn btn-primary" onclick="setSubmitType('reenvio_empresa')">Reenviar Trámite</button>
                                    @endif

                                    @if (in_array(Auth::user()->role_id, [16, 17, 18]) && in_array($tramite->estado, ['INICIADO', 'REENVIADO POR EMPRESA', 'DEVUELTO A AREA']) && in_array($zona, ['appm', 'ape', 'apcr']))
                                        <button type="submit" class="btn btn-warning" onclick="setSubmitType('devolver')">Devolver a Productor</button>
                                        <button type="submit" class="btn btn-success" onclick="setSubmitType('evaluado')">Enviar a Nivel Central</button>
                                    @endif

                                    @if (Auth::user()->role_id === 9 && $tramite->estado === 'INICIADO' && $zona === 'nc')
                                        <button type="submit" class="btn btn-warning" onclick="setSubmitType('devolver')">Devolver</button>
                                        <button type="submit" class="btn btn-success" onclick="setSubmitType('aprobar')">Aprobar</button>
                                    @endif

                                    @if (Auth::user()->role_id === 9 && $tramite->estado === 'EVALUADO POR AREA PROGRAMATICA')
                                        <button type="submit" class="btn btn-warning" onclick="setSubmitType('devolver')">Devolver</button>
                                        <button type="submit" class="btn btn-success" onclick="setSubmitType('aprobar')">Aprobar</button>
                                    @endif

                                    @if (Auth::user()->role_id === 9 && $tramite->estado === 'REENVIADO POR EMPRESA' && $zona === 'nc')
                                        <button type="submit" class="btn btn-warning" onclick="setSubmitType('devolver')">Devolver</button>
                                        <button type="submit" class="btn btn-success" onclick="setSubmitType('aprobar')">Aprobar</button>
                                    @endif

                                    @if (Auth::user()->role_id === 9 && $tramite->estado === 'DEVUELTO A NC')
                                        <button type="submit" class="btn btn-warning" onclick="setSubmitType('devolver')">Devolver</button>
                                        <button type="submit" class="btn btn-success" onclick="setSubmitType('aprobar')">Aprobar</button>
                                    @endif

                                    @if (Auth::user()->role_id === 1 && $tramite->estado === 'APROBADO')
                                        <button type="submit" class="btn btn-danger" onclick="setSubmitType('devolver')">Devolver</button>
                                        <button type="submit" class="btn btn-success" onclick="setSubmitType('inscribir')">Inscribir Producto</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //  Modal para agregar expediente -->
<div class="modal fade" id="agregarexp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Iniciar Expediente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('expedientedb') }}" method="post">
        {{ csrf_field() }}
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Fecha</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control form-control-sm" name="fecha">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Descripción</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" name="descripcion">
                </div>
            </div>
            <input type="hidden" name="rpadb_id" value="{{ $rpadb->id }}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    function setSubmitType(tipo) {
        document.getElementById('submitType').value = tipo;
    }
</script>
@endsection