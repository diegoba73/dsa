@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.facturas.edit', 'title' => __('Sistema DPSA')])
@section('content')
<div class="header bg-primary pb-8 pt-5 pt-md-6">
        <div class="container-fluid">

                <div class="card-body">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                </div>
            <div class="content bg-primary">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="alert alert-default">
                                    <strong class="card-title">Editar Factura</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-group form-prevent-multiple-submit" method="POST" action="{{ route('factura.update', $factura->id) }}">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Ítems del Nomenclador:</label>
                                        <select class="chosen-select" id="nomenclador-select" name="selected_nomencladors[]" multiple>
                                            @foreach ($nomencladors as $nomenclador)
                                                @if ($nomenclador->departamento_id == $userDepartamentoId)
                                                    <option value="{{ $nomenclador->id }}" data-departamento="{{ $nomenclador->departamento_id }}">
                                                        {{ $nomenclador->descripcion }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <table class="table" id="selected-nomencladors-table">
                                            <thead>
                                                <tr>
                                                    <th>Ítem</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aquí se agregarán las filas de ítems seleccionados -->
                                                @foreach ($factura->nomencladors as $nomenclador)
                                                    <tr>
                                                        <td>{{ $nomenclador->descripcion }}</td>
                                                        <td>
                                                            <input type="number" class="form-control" name="nomenclador_cantidades[{{ $nomenclador->id }}]" value="{{ $nomenclador->pivot->cantidad }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <a class="btn btn-default btn-close" href="{{ route('facturas_index') }}">Cancelar</a>
                                    <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                        <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                        Actualizar
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>   
@endsection