@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.rpadb.edit', 'title' => __('Sistema DPSA')])

@section('content')
{{ Form::hidden('url', URL::full()) }}

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

        <div class="content bg-primary">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-header bg-default">
                                <h4 class="card-title font-weight-bold mb-0 text-white">
                                    Inicio de Trámite de Modificacion Registro R.P.A.D.B. {{ $rpadb->numero }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('rpadb.update_modificacion', ['id' => $rpadb->id]) }}" method="POST" enctype="multipart/form-data">
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
                                                        <input type="text" class="form-control" name="denominacion" value="{{ $rpadb->denominacion }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Nombre Fantasía:</label>
                                                        <input type="text" class="form-control" name="nombre_fantasia" value="{{ $rpadb->nombre_fantasia }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Marca:</label>
                                                        <input type="text" class="form-control" name="marca" value="{{ $rpadb->marca }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Establecimiento relacionado:</label>
                                                        <select class="form-control" name="dbredb_id">
                                                            <option value="">-- Seleccionar --</option>
                                                            @foreach($redbs as $redb)
                                                                <option value="{{ $redb->id }}" {{ (int) $rpadb->dbredb_id === (int) $redb->id ? 'selected' : '' }}>
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
                                    @include('db.rpadb.partials.envasesm')

                                    <h2 class="text-primary font-weight-bold mt-4">Documentación Adjunta</h2>
                                    <hr>
                                    @include('db.rpadb.partials.documentacionm')

                                    <h2 class="text-primary font-weight-bold mt-4">Observaciones</h2>
                                    <hr>
                                    {{-- HISTORIAL DE OBSERVACIONES COMO CHAT --}}
                                    <div class="card mt-4">
                                        <div class="card-header bg-gradient-info text-white">
                                            <strong>Conversación / Observaciones</strong>
                                        </div>
                                    </div>

                                    {{-- AGREGAR OBSERVACIÓN --}}
                                        <div class="form-group mt-3">
                                            <label for="observaciones">Agregar observación:</label>
                                            <textarea name="observaciones" class="form-control" rows="3" placeholder="Escriba una nueva observación..." required>{{ old('observaciones') }}</textarea>
                                            @error('observaciones')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                    <input type="hidden" name="submitType" id="submitType" value="">

                                    <div class="text-center mt-4">
                                        <a class="btn btn-default" href="{{ URL::previous() }}">Cancelar</a>

                                        @if (Auth::user()->role_id === 15 )
                                            <button type="submit" class="btn btn-primary" onclick="setSubmitType('reenvio_empresa')">Enviar Trámite</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let nuevoId = Date.now();

        document.querySelector('.addE')?.addEventListener('click', function () {
            const tabla = document.querySelector('#item_tableE tbody');
            if (!tabla) return;

            let html = `
                <tr>
                    <td>Nuevo</td>
                    <td><input type="text" name="envases[new_${nuevoId}][tipo_envase]" class="form-control"></td>
                    <td><input type="text" name="envases[new_${nuevoId}][material]" class="form-control"></td>
                    <td><input type="text" name="envases[new_${nuevoId}][contenido_neto]" class="form-control"></td>
                    <td><input type="text" name="envases[new_${nuevoId}][contenido_escurrido]" class="form-control"></td>
                    <td><input type="text" name="envases[new_${nuevoId}][lapso_aptitud]" class="form-control"></td>
                    <td><input type="text" name="envases[new_${nuevoId}][condiciones_conservacion]" class="form-control"></td>
                    <td><input type="file" name="envases[new_${nuevoId}][certificado_envase]" class="form-control"></td>
                    <td><input type="file" name="envases[new_${nuevoId}][rotulo_envase]" class="form-control"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove"><i class="fas fa-trash"></i></button></td>
                </tr>`;
            tabla.insertAdjacentHTML('beforeend', html);
            nuevoId++;
        });

        document.querySelector('#item_tableE').addEventListener('click', function (e) {
            if (e.target.closest('.remove')) {
                e.target.closest('tr').remove();
            }
        });
    });
</script>
@endsection