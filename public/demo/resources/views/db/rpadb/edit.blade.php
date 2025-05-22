@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.rpadb.edit', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Actualizar Registro {{$rpadb->nombre_fantasia}}</strong>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('db_rpadb_update', $rpadb->id) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        @method('PUT')
                                        <div class="row justify-content-center align-items-center">
                                            <div class="form-group">
                                                <div class="text-center">
                                                    <label class="bmd-label-floating">Establecimiento: {{ $rpadb->redb->razon }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @if ((Auth::user()->departamento_id = 2) && (Auth::user()->role_id <> 15))
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nro de Expediente:</label>
                                                    <input type="text" class="form-control form-control-sm" name="expediente" value="{{ $rpadb->expediente}}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <br>
                                                <a href="#" class="btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#agregarexp">
                                                    Nº Expediente
                                                </a>
                                            </div>
                                            @endif
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Denominación:</label>
                                                <input type="text" class="form-control" name="denominacion" value="{{ $rpadb->denominacion}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Nombre Fantasía:</label>
                                                <input type="text" class="form-control" name="nombre_fantasia" value="{{ $rpadb->nombre_fantasia}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Marca:</label>
                                                    <input type="text" class="form-control" name="marca" value="{{ $rpadb->marca}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Envase:</label>
                                                <input type="text" class="form-control" name="envase" value="{{ $rpadb->envase}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Lote:</label>
                                                <input type="text" class="form-control" name="lote" value="{{ $rpadb->lote}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Fecha de Envasado:</label>
                                                <input type="text" class="form-control" name="fecha_envasado" value="{{ $rpadb->fecha_envasado}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Fecha de Vencimineto:</label>
                                                <input type="text" class="form-control" name="fecha_vencimiento" value="{{ $rpadb->fecha_vencimiento}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Lapso de aptitud:</label>
                                                <input type="text" class="form-control" name="lapso_aptitud" value="{{ $rpadb->lapso_aptitud}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>      
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Contenido Neto:</label>
                                                <input type="text" class="form-control" name="contenido_neto" value="{{ $rpadb->contenido_neto}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>                                        
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Peso Escurrido:</label>
                                                <input type="text" class="form-control" name="peso_escurrido" value="{{ $rpadb->peso_escurrido}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Unidad de venta:</label>
                                                <input type="text" class="form-control" name="unidad_venta" value="{{ $rpadb->unidad_venta}}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                            <div class="form-group">
                                                <label class="label-control">Fecha de Inscripción:</label>
                                                <input type="date" class="form-control form-control-sm" id="fecha_inscripcion" name="fecha_inscripcion" value="{{ $rpadb->fecha_inscripcion }}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                <small class="form-text text-danger">*Requerido.</small>
                                            </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                        <label class="label-control">Fecha de Reinscripción:</label>
                                                        <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_reinscripcion" value="{{ $rpadb->fecha_reinscripcion }}" {{ (Auth::user()->role_id !== 15) ? 'readonly' : '' }}>
                                                        <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div id="rubros">
                                                    <!-- Aquí muestra los rubros correspondientes a este Dbrpadb -->
                                                    <table class="table table-bordered" style="margin-bottom: 80px;" id="item_tableR">
                                                        <tr>
                                                            <th scope="col"></th>
                                                            <th>id</th>
                                                            <th>REDB</th>
                                                            <th>Rubro</th>
                                                            <th>Categorías</th>
                                                            <th>Actividades</th>
                                                        </tr>
                                                        @foreach($pivotcat as $item)
                                                            <tr>
                                                                <td style="width:1px">
                                                                    <!-- Modifica el checkbox inicial para que refleje la selección -->
                                                                    <input type="radio" class="control-input" name="selected_item_id" value="{{ $item->id }}" {{ $item->id === $rpadb->dbredb_dbrubro_id ? 'checked' : '' }} {{ (Auth::user()->role_id !== 15) ? 'disabled' : '' }}>
                                                                </td>
                                                                <td>{{ $item->id }}</td>
                                                                <td>{{ $item->redb_numero }}</td>
                                                                <td>{{ $item->rubro_nombre }}</td>
                                                                <td>{{ $item->categoria_nombre }}</td>
                                                                <td>{{ $item->actividad }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Artículo del CAA:</label>
                                                    <input type="text" class="form-control" name="articulo_caa" value="{{ $rpadb->articulo_caa}}" <?php echo (Auth::user()->role_id !== 15) ? 'disabled' : ''; ?>>
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 50px;">
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="analisis">Análisis:</label>
                                                    <input type="file" class="form-control" name="analisis" id="analisis" <?php echo (Auth::user()->role_id !== 15) ? 'disabled' : ''; ?>>
                                                    @if($rpadb->ruta_analisis)
                                                        <a href="{{ route('verANALISISprod', $rpadb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label for="ingredientes">Ingredientes:</label>
                                                    <input type="file" class="form-control" name="ingredientes" id="ingredientes" <?php echo (Auth::user()->role_id !== 15) ? 'disabled' : ''; ?>>
                                                    @if($rpadb->ruta_analisis)
                                                        <a href="{{ route('verING', $rpadb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="especificaciones">Especificaciones técnicas:</label>
                                                    <input type="file" class="form-control" name="especificaciones" id="especificaciones" <?php echo (Auth::user()->role_id !== 15) ? 'disabled' : ''; ?>>
                                                    @if($rpadb->ruta_especificaciones)
                                                        <a href="{{ route('verESP', $rpadb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="monografia">Monografia e informacion nutricional:</label>
                                                    <input type="file" class="form-control" name="monografia" id="monografia" <?php echo (Auth::user()->role_id !== 15) ? 'disabled' : ''; ?>>
                                                    @if($rpadb->ruta_monografia)
                                                        <a href="{{ route('verMONO', $rpadb->id) }}" target="_blank">Ver Monografia Guardado en Base de Datos</a>
                                                    @endif
                                                    @if($rpadb->ruta_infonut)
                                                        <a href="{{ route('verINFO', $rpadb->id) }}" target="_blank">Ver Información Nutricional Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="rotulo">Rótulo:</label>
                                                    <input type="file" class="form-control" name="rotulo" id="rotulo" <?php echo (Auth::user()->role_id !== 15) ? 'disabled' : ''; ?>>
                                                    @if($rpadb->ruta_rotulo)
                                                        <a href="{{ route('verROTULO', $rpadb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="certenvase">Certificado de envase de uso alimentario:</label>
                                                    <input type="file" class="form-control" name="certenvase" id="certenvase" <?php echo (Auth::user()->role_id !== 15) ? 'disabled' : ''; ?>>
                                                    @if($rpadb->ruta_certenvase)
                                                        <a href="{{ route('verCERTENVASE', $rpadb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="plano">Comprobante de pago:</label>
                                                    <input type="file" class="form-control" name="pago" id="pago" <?php echo (Auth::user()->role_id !== 15) ? 'disabled' : ''; ?>>
                                                    @if($rpadb->ruta_pago)
                                                        <a href="{{ route('verPAGO', $rpadb->id) }}" target="_blank">Ver Archivo Guardado en Base de Datos</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if($historial)
                                            <div class="row">
                                                <div class="col">
                                                    <label for="detalle">Ultima devolución hecha por {{ $historial->user->usuario }}:</label><br>
                                                    <textarea id="detalle" name="ultimo" rows="4" cols="250" readonly>{{ $historial->observaciones }}</textarea>
                                                    <br>
                                                </div>
                                            </div>   
                                            <div class="row" style="padding-top: 50px;">
                                                <div class="col">
                                                    @if(Auth::id() != $historial->user_id)
                                                        <label for="detalle">Tu devolución:</label><br>
                                                        <textarea id="detalle" name="observaciones" rows="4" cols="250" value=""></textarea>
                                                    @elseif (Auth::user()->role_id == 15)
                                                        <h1 style="text-align: center; color: red;">EL TRÁMITE SE ESTA EVALUANDO</h1>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                            <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit" name="submit">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                Actualizar
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
<!-- Modal -->

<div class="modal fade" id="agregarexp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Iniciar Expediente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
        <form action="{{route('expedientedb')}}" method="post">
      		{{csrf_field()}}
	      <div class="modal-body">

            <div class="form-group">
                <div class="form-group">
                <label class="control-label col-sm-6"for="fecha">Fecha</label>
                    <div class="col-sm-6">
                    <input type="date" class="form-control form-control-sm" name="fecha">
                    </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-6"for="descripcion">Descripción</label>
                    <div class="col-sm-6">
                    <input type="name" class="form-control form-control-sm" name="descripcion">
                    </div>
                </div>
            </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar</button>
	      </div>
        </form>
    </div>
  </div>
</div> 
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Función para resaltar la fila seleccionada al cargar el formulario
        var selectedRadio = $('input[name="selected_item_id"]:checked');
        if (selectedRadio.length > 0) {
            selectedRadio.closest('tr').css('background-color', '#f2f2f2');
        }

        // Captura el cambio de selección en los radio buttons
        $('input[name="selected_item_id"]').change(function() {
            // Remueve el estilo de todas las filas
            $('#item_tableR tr').css('background-color', '');

            // Agrega el estilo a la fila seleccionada
            $(this).closest('tr').css('background-color', '#f2f2f2');
            
            // Remueve la selección de otros radio buttons
            $('input[name="selected_item_id"]').not(this).prop('checked', false);
        });
    });
</script>

