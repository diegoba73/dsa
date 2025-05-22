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
                                    <form class="form-group form-prevent-multiple-submit" method="post"
                                          action="{{ url('/inspeccion/'.$inspeccion->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="label-control">Fecha:</label>
                                                <input type="date" value="{{ $inspeccion->fecha }}" class="form-control"
                                                       id="datepicker" name="fecha">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <select class="chosen-select" name="establecimiento" id="estSelect">
                                                <option disabled>Seleccionar Establecimiento</option>
                                                @foreach($establecimientos as $estOption)
                                                    <option value="{{$estOption->establecimiento}}" data-establecimiento-id="{{$estOption->id}}" @if($estOption->id == $inspeccion->dbredb_id) selected @endif>{{$estOption->establecimiento}}</option>
                                                @endforeach
                                                <option value="otro" data-establecimiento-id="NULL" @if($inspeccion->dbredb_id === null) selected @endif>Otro</option>
                                            </select>

                                            <div id="otroEst" style="display: none;">
                                                <input type="text" name="otroEst" id="otroEstInput" placeholder="Ingrese otro establecimiento" @if($inspeccion->dbredb_id === null) value="{{$inspeccion->establecimiento}}" @endif>
                                                <!-- Agregamos un campo oculto para enviar el ID de la razón -->
                                                <input type="hidden" name="dbredb_id" id="estIdInput" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Dirección:</label>
                                            <input type="text" class="form-control" name="direccion" value="{{ $inspeccion->direccion }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="provincia">Localidad:</label><br>
                                            <select class="chosen-select" name="localidad_id" id="localidad">
                                                <option disabled>Seleccionar Localidad</option>
                                                @foreach($localidads as $localidad)
                                                    <option value="{{$localidad->id}}" @if($localidad->id == $inspeccion->localidad_id) selected @endif>{{$localidad->localidad}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Rubro:</label>
                                            <input type="text" class="form-control" name="rubro" value="{{ $inspeccion->rubro }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Motivo:</label>
                                            <select class="form-control" name="motivo">
                                                <option value="Preinscripcion" {{ $inspeccion->motivo == 'Preinscripcion' ? 'selected' : '' }}>Preinscripción</option>
                                                <option value="Inscripcion" {{ $inspeccion->motivo == 'Inscripcion' ? 'selected' : '' }}>Inscripción</option>
                                                <option value="Reinscripcion" {{ $inspeccion->motivo == 'Reinscripcion' ? 'selected' : '' }}>Reinscripción</option>
                                                <option value="Baja" {{ $inspeccion->motivo == 'Baja' ? 'selected' : '' }}>Baja</option>
                                                <option value="Modificacion" {{ $inspeccion->motivo == 'Modificacion' ? 'selected' : '' }}>Modificación</option>
                                                <option value="Rutina" {{ $inspeccion->motivo == 'Rutina' ? 'selected' : '' }}>Rutina</option>
                                                <option value="Intoxicacion" {{ $inspeccion->motivo == 'Intoxicacion' ? 'selected' : '' }}>Intoxicación</option>
                                                <option value="Denuncia" {{ $inspeccion->motivo == 'Denuncia' ? 'selected' : '' }}>Denuncia</option>
                                                <option value="Otro" {{ $inspeccion->motivo == 'Otro' ? 'selected' : '' }}>Otro</option>
                                            </select>
                                        </div>
                                        <label for="detalle">Detalle de la inspección:</label><br>
                                        <textarea id="detalle" name="detalle" rows="4" cols="105"> {{ $inspeccion->detalle }}</textarea>
                                        <div class="form-group">
                                            <label for="tipo_prestacion">Higiene:</label>
                                            <p>
                                            {!! Form::select(
                                                'higiene', 
                                                ['Seleccionar', 'MALA' => 'MALA', 'BUENA' => 'BUENA', 'EXCELENTE' => 'EXCELENTE'],
                                                $inspeccion->higiene,
                                                ['class' => 'chosen-select']
                                            ) !!}
                                            <small class="form-text text-danger">* Campo requerido.</small>
                                            </p>
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('db_inspeccion_index') }}">Cancelar</a>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Función para manejar el cambio en el select
    $('#estSelect').change(function() {
        var selectedValue = $(this).val();
        var otroEstDiv = $('#otroEst');
        var otroEstInput = $('#otroEstInput');

        // Mostrar u ocultar el campo "Otro" según la selección
        if (selectedValue === 'otro') {
            otroEstDiv.show();
            // Establecer el valor del campo "razon_id" como NULL
            $('#estIdInput').val('NULL');
        } else {
            otroEstDiv.hide();
            // Obtener el valor del atributo data-razon-id de la opción seleccionada
            var selectedOption = $('#estSelect option:selected');
            var estId = selectedOption.data('establecimiento-id');
            // Establecer el valor del campo "razon_id" con el ID de la opción seleccionada
            $('#estIdInput').val(estId);
        }
    });

    // Función para manejar el envío del formulario
    $('form').submit(function(event) {
        var selectedValue = $('#estSelect').val();

        if (selectedValue === 'otro') {
            var otroEst = $('#otroEstInput').val();

            // Solo establecemos el valor de la razón y eliminamos la asignación al campo de ID
            $('#estSelect').val(otroEst);
            $('#otroEstInput').attr('name', 'establecimiento');
            $('#otroEstInput').val(otroEst);

            // Eliminamos la asignación al campo de ID antes del envío del formulario
            $('#estIdInput').val('');
        } else {
            // Si no es "Otro", dejamos que el formulario envíe tanto la razón como el ID
            $('#otroEstInput').removeAttr('name');
        }
    });

    // Mostrar u ocultar el campo "Otro" al cargar la página según la selección inicial
    $('#estSelect').trigger('change');
});

</script>