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
                                        <select class="chosen-select" name="establecimiento" id="estSelect">
                                            <option disabled selected>Seleccionar Establecimiento</option>
                                            @foreach($establecimientos as $estOption)
                                                <option value="{{$estOption->establecimiento}}" data-establecimiento-id="{{$estOption->id}}">
                                                    {{ $estOption->numero . ' - ' . $estOption->establecimiento . ' - ' . $estOption->transito }}
                                                </option>
                                            @endforeach
                                            <option value="otro" data-establecimiento-id="NULL">Otro</option>
                                        </select>
                                        <div id="otroEst" style="display: none;">
                                            <input type="text" name="otroEst" id="otroEstInput" placeholder="Ingrese otro Establecimiento">
                                            <!-- Agregamos un campo oculto para enviar el ID de la razón -->
                                            <input type="hidden" name="dbredb_id" id="estIdInput" value="">
                                        </div>
                                    </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Dirección:</label>
                                            <input type="text" class="form-control" name="direccion">
                                        </div>
                                        <div class="form-group">
                                                    <label for="localidad">Localidad:</label><br>
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
                                            <select class="form-control" name="motivo">
                                                <option value="Preinscripcion">Preinscripción</option>
                                                <option value="Inscripcion">Inscripción</option>
                                                <option value="Reinscripcion">Reinscripción</option>
                                                <option value="Baja">Baja</option>
                                                <option value="Modificacion">Modificación</option>
                                                <option value="Rutina">Rutina</option>
                                                <option value="Intoxicacion">Intoxicación</option>
                                                <option value="Denuncia">Denuncia</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="detalle">Detalle de la inspección:</label><br>
                                            <textarea id="detalle" name="detalle" rows="4" cols="105">// Aquí puedes escribir tu texto. //</textarea>
                                        </div>
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
    function toggleFields() {
        var selectedValue = $('#estSelect').val();
        var otroEstDiv = $('#otroEst');
        var estIdInput = $('#estIdInput');
        var localidad = $('#localidad').parent(); // Asumiendo que el div que contiene la localidad tiene la clase form-group
        var direccion = $('input[name="direccion"]').parent();
        var rubro = $('input[name="rubro"]').parent();

        if (selectedValue === 'otro') {
            otroEstDiv.show();
            localidad.show();
            direccion.show();
            rubro.show();
            estIdInput.val('NULL');
        } else if (selectedValue) {
            otroEstDiv.hide();
            localidad.hide();
            direccion.hide();
            rubro.hide();
            var selectedOption = $('#estSelect option:selected');
            var estId = selectedOption.data('establecimiento-id');
            estIdInput.val(estId);
        } else {
            otroEstDiv.hide();
            localidad.show();
            direccion.show();
            rubro.show();
        }
    }

    // Evento change del selector de establecimiento
    $('#estSelect').change(toggleFields);

    // Llamada inicial para establecer la visibilidad correcta al cargar la página
    toggleFields();

    $('form').submit(function(event) {
        var selectedValue = $('#estSelect').val();

        if (selectedValue === 'otro') {
            var otroEst = $('#otroEstInput').val();
            $('#estSelect').val(otroEst);
            $('#otroEstInput').attr('name', 'establecimiento');
            $('#otroEstInput').val(otroEst);
            $('#estIdInput').val('');
        } else {
            $('#otroEstInput').removeAttr('name');
        }
    });
});
</script>
