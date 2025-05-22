@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.redb.baja', 'title' => __('Sistema DPSA')])
@section('content')
{{ Form::hidden('url', URL::full()) }}
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
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
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
                                    <strong class="card-title">Solicitud Baja de Registro R.E.D.B. {{$redb->establecimiento}}</strong>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('db_redb_create_baja', $redb->id) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nro Exp.:</label>
                                                    <input type="text" class="form-control form-control-sm" name="expediente" value="{{ $tramite->dbexp->numero ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Razón:</label>
                                                <input type="text" class="form-control form-control-sm" name="establecimiento" value="{{ $redb->establecimiento }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Domicilio:</label>
                                                <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ $redb->domicilio }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="localidad">Localidad:</label><br>
                                                    <input type="text" class="form-control form-control-sm" name="domicilio" value="{{ $redb->localidad->localidad }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Motivo de la solicitud:</label>
                                                <input type="text" class="form-control form-control-sm" name="observaciones" value="{{ $tramite->observaciones }}" {{ (Auth::user()->role_id != 15) ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="dni">ULTIMA ACTA DE INSPECCION:</label>
                                                    <div id="vistaPreviaActa"></div>
                                                    @if($redb->ruta_acta)
                                                        <a href="{{ route('verACTA', $redb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                            <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                            <button type="submit" class="btn btn-danger" name="submitType" value="devolver_empresa">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                DAR DE BAJA
                                            </button>
                                        </div>
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
<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>    
<script>

    $(document).ready(function() {
        // vista previa analisis
        document.getElementById('analisis').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaAnalisis').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
        });

        // vista previa memoria
        document.getElementById('memoria').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaMemoria').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

        // vista previa contrato
        document.getElementById('contrato').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaContrato').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

            // vista previa habilitacion
        document.getElementById('habilitacion').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaHab').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

        // vista previa plano
        document.getElementById('plano').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaPlano').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });

        // vista previa acta
        document.getElementById('acta').addEventListener('change', function(event) {
        var archivo = event.target.files[0];
        if (archivo && archivo.type === 'application/pdf') {
            var lector = new FileReader();

            lector.onload = function(e) {
                var embedTag = '<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="410px"/>';
                document.getElementById('vistaPreviaActa').innerHTML = embedTag;
            };

            lector.readAsDataURL(archivo);
        } else {
            // Si el archivo no es un PDF, puedes mostrar un mensaje de error o simplemente no hacer nada.
            alert('Por favor, seleccione un archivo PDF.');
            event.target.value = ''; // Limpiar el input de archivo para evitar la subida de archivos no deseados.
        }
    });
});

</script>
@endsection
