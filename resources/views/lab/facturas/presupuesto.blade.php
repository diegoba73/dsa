@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'dsa.facturas.presupuesto', 'title' => __('Sistema DPSA')])
@section('content')
<div class="header bg-primary pb-8 pt-5 pt-md-6">
        <div class="container-fluid">

                <div class="card-body">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $messages)
                                            <li>{{$messages}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                </div>
            <div class="content bg-primary">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="alert alert-default">
                                    <strong class="card-title">Presupuesto</strong>
                                </div>
                                <div class="card-body">
                                <form class="form-group form-prevent-multiple-submit" method="post" action="{{ route('generar.pdf') }}" target="_blank">
                                    {{ csrf_field() }}
                                    <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="label-control">Fecha de Emisión:</label>
                                        <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="datepicker" name="fecha_emision">
                                    </div>
                                    </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="remitente">Remitente:</label><br>
                                                <select class="chosen-select" name="remitente">
                                                    <option disabled selected>Seleccionar Remitente</option>
                                                    @foreach($remitentes as $remitente)
                                                        <option value="{{$remitente->nombre}}">{{$remitente->nombre}}</option>
                                                    @endforeach
                                                </select>
                                                <small class="form-text text-danger">* El Solicitante es requerido.</small>
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Ítems del Nomenclador:</label>
                                                <select class="chosen-select" id="nomenclador-select-pre" name="selected_nomencladors[]" multiple>
                                                    @foreach ($nomencladors as $nomenclador)
                                                        <option value="{{ $nomenclador->id }}" data-valor="{{ $nomenclador->valor }}">
                                                            {{ $nomenclador->descripcion }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @foreach ($nomencladors as $nomenclador)
                                                <input type="hidden" name="nomenclador_precios[{{ $nomenclador->id }}]" value="{{ $nomenclador->valor }}">
                                            @endforeach

                                            <div class="form-group">
                                                <label class="bmd-label-floating">Ítems Ensayo:</label>
                                                <select class="chosen-select" id="ensayo-select-pre" name="selected_ensayos[]" multiple>
                                                    @foreach ($ensayos as $ensayo)
                                                        <option value="{{ $ensayo->id }}" data-costo="{{ $ensayo->costo }}">
                                                            {{ $ensayo->ensayo }} - {{ $ensayo->matriz->matriz }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @foreach ($ensayos as $ensayo)
                                                <input type="hidden" name="ensayo_costos[{{ $ensayo->id }}]" value="{{ $ensayo->costo }}">
                                            @endforeach

                                            <div class="form-group">
                                                <table class="table" id="selected-nomencladors-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Ítem</th>
                                                            <th>Valor unitario</th>
                                                            <th>Cantidad</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Aquí se agregarán las filas de ítems seleccionados -->
                                                        <td><input type="number" class="form-control cantidad" name="nomenclador_cantidades[' + value + ']" placeholder="Cantidad"></td>
                                                        <td><input type="text" class="form-control subtotal" readonly></td>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="form-group">
                                                <label>Total Factura:</label>
                                                <input type="text" class="form-control" id="total-factura" readonly>
                                            </div>

                                        <a class="btn btn-default btn-close" href="{{ route('facturas_index') }}">Cancelar</a>
                                        <button type="submit" class="btn btn-primary pull-center">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    Hacer presupuesto
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