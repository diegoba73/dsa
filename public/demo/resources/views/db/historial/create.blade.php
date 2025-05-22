@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.mesaentrada.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Ingreso Inspección</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/inspeccion') }}">
                                    {{ csrf_field() }}
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Fecha:</label>
                                            <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="datepicker" name="fecha">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <select class="chosen-select" name="razon" id="razonSelect">
                                            <option disabled selected>Seleccionar Razón</option>
                                            @foreach($razones as $razonOption)
                                                <option value="{{$razonOption->razon}}" data-razon-id="{{$razonOption->id}}">{{$razonOption->razon}}</option>
                                            @endforeach
                                            <option value="otro" data-razon-id="NULL">Otro</option>
                                        </select>

                                        <div id="otraRazon" style="display: none;">
                                            <input type="text" name="otraRazon" id="otraRazonInput" placeholder="Ingrese otra razón">
                                            <!-- Agregamos un campo oculto para enviar el ID de la razón -->
                                            <input type="hidden" name="razon_id" id="razonIdInput" value="">
                                        </div>
                                    </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Dirección:</label>
                                            <input type="text" class="form-control" name="direccion">
                                        </div>
                                        <div class="form-group">
                                                    <label for="provincia">Localidad:</label><br>
                                                    <select class="chosen-select" name="localidad_id" id="localidad">
                                                        <option disabled selected>Seleccionar Localidad</option>
                                                        @foreach($localidads as $localidad)
                                                        <option value="{{$localidad->id}}">{{$localidad->localidad}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Rubro:</label>
                                            <input type="text" class="form-control" name="rubro">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Motivo:</label>
                                            <input type="text" class="form-control" name="motivo">
                                        </div>
                                        <label for="detalle">Detalle de la inspección:</label><br>
                                            <textarea id="detalle" name="detalle" rows="4" cols="200">
                                            Aquí puedes escribir tu texto.
                                            </textarea>
                                            <div class="form-group">
                                                        <label for="tipo_prestacion">Higiene:</label>
                                                            <p>
                                                            {!! Form::select(
                                                                'higiene', 
                                                                ['Seleccionar', 'MALA' => 'MALA', 'BUENA' => 'BUENA', 'EXCELENTE' => 'EXCELENTE'],
                                                                (auth()->user()->role_id === 13) ? 'ARANCELADO' : null,
                                                                ['class' => 'chosen-select']
                                                            ) !!}
                                                            <small class="form-text text-danger">* Campo requerido.</small>
                                                            </p>
                                                </div>
                                        <a class="btn btn-default btn-close" href="{{ route('db_inspeccion_index') }}">Cancelar</a>
                                        <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    Ingresar
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#razonSelect').change(function() {
        var selectedValue = $(this).val();
        var otraRazonDiv = $('#otraRazon');
        var razonIdInput = $('#razonIdInput');

        if (selectedValue === 'otro') {
            otraRazonDiv.show();
            // Establecer el valor del campo "razon_id" como NULL
            razonIdInput.val('NULL');
        } else {
            otraRazonDiv.hide();
            // Obtener el valor del atributo data-razon-id de la opción seleccionada
            var selectedOption = $('#razonSelect option:selected');
            var razonId = selectedOption.data('razon-id');
            
            // Establecer el valor del campo "razon_id" con el ID de la opción seleccionada
            razonIdInput.val(razonId);
        }
    });

    $('form').submit(function(event) {
        var selectedValue = $('#razonSelect').val();

        if (selectedValue === 'otro') {
            var otraRazon = $('#otraRazonInput').val();

            // Solo establecemos el valor de la razón y eliminamos la asignación al campo de ID
            $('#razonSelect').val(otraRazon);
            $('#otraRazonInput').attr('name', 'razon');
            $('#otraRazonInput').val(otraRazon);

            // Eliminamos la asignación al campo de ID antes del envío del formulario
            $('#razonIdInput').val('');
        } else {
            // Si no es "Otro", dejamos que el formulario envíe tanto la razón como el ID
            $('#otraRazonInput').removeAttr('name');
        }
    });
});
</script>