@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.rpadb.edit', 'title' => __('Sistema DPSA')])

@section('content')
{{ Form::hidden('url', URL::full()) }}

@php
    $modoEdicion = Auth::user()->role_id === 15;
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

        <div class="content bg-primary">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-header bg-default">
                                <h4 class="card-title font-weight-bold mb-0 text-white">
                                    Solicitud de Reinscripción del Producto: {{ $rpadb->denominacion }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('rpadb.store_reinscripcion', ['id' => $rpadb->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

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
                                    <p class="text-muted">Este producto aún no tiene trámite de reinscripción iniciado. Se podrán visualizar observaciones una vez iniciado.</p>

                                    <input type="hidden" name="submitType" id="submitType" value="iniciar_reinscripcion">

                                    <div class="text-center mt-4">
                                        <a class="btn btn-default" href="{{ URL::previous() }}">Cancelar</a>
                                        @if (Auth::user()->role_id === 15)
                                            <button type="submit" class="btn btn-warning">Solicitar Reinscripción</button>
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

{{-- Scripts para manipular dinámicamente envases --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let nuevoId = Date.now();

        document.querySelector('.addE')?.addEventListener('click', function () {
            const tabla = document.querySelector('#item_tableE tbody');
            if (!tabla) return;

            let html = `
                <tr>
                    <td>Nuevo</td>
                    <td><input type="text" name="productos[0][envases][new_${nuevoId}][tipo_envase]" class="form-control"></td>
                    <td><input type="text" name="productos[0][envases][new_${nuevoId}][material]" class="form-control"></td>
                    <td><input type="text" name="productos[0][envases][new_${nuevoId}][contenido_neto]" class="form-control"></td>
                    <td><input type="text" name="productos[0][envases][new_${nuevoId}][contenido_escurrido]" class="form-control"></td>
                    <td><input type="text" name="productos[0][envases][new_${nuevoId}][lapso_aptitud]" class="form-control"></td>
                    <td><input type="text" name="productos[0][envases][new_${nuevoId}][condiciones_conservacion]" class="form-control"></td>
                    <td><input type="file" name="productos[0][envases][new_${nuevoId}][certificado_envase]" class="form-control"></td>
                    <td><input type="file" name="productos[0][envases][new_${nuevoId}][rotulo_envase]" class="form-control"></td>
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