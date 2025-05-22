@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.rpadb.create', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Ingreso Registro</strong>
                                </div>
                                <div class="card-body">
                                    <form name="form_check" id="form_check" class="form-prevent-multiple-submit" method="post" action="{{ url('/rpadb/') }}" enctype="multipart/form-data"> 
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Denominación:</label>
                                                <input type="text" class="form-control" name="denominacion">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Nombre Fantasía:</label>
                                                <input type="text" class="form-control" name="nombre_fantasia">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Marca:</label>
                                                    <input type="text" class="form-control" name="marca">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Envase:</label>
                                                <input type="text" class="form-control" name="envase">
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Lote:</label>
                                                <input type="text" class="form-control" name="lote">
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Fecha de Envasado:</label>
                                                <input type="text" class="form-control" name="fecha_envasado">
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Fecha de Vencimineto:</label>
                                                <input type="text" class="form-control" name="fecha_vencimiento">
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Lapso de aptitud:</label>
                                                <input type="text" class="form-control" name="lapso_aptitud">
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>      
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Contenido Neto:</label>
                                                <input type="text" class="form-control" name="contenido_neto">
                                                <small class="form-text text-danger">* Requerido.</small>
                                                </div>
                                            </div>                                        
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Peso Escurrido:</label>
                                                <input type="text" class="form-control" name="peso_escurrido">
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                <label class="bmd-label-floating">Unidad de venta:</label>
                                                <input type="text" class="form-control" name="unidad_venta">
                                                <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                        <label class="label-control">Fecha de Inscripción:</label>
                                                        <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_inscripcion" value="<?php echo date('Y-m-d'); ?>">
                                                        <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group">
                                                        <label class="label-control">Fecha de Reinscripción:</label>
                                                        <input type="date" class="form-control form-control-sm" id="datepicker" name="fecha_reinscripcion" value="<?php echo date('Y-m-d'); ?>">
                                                        <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div id="rubros">
                                                    <!-- Aquí muestra los rubros correspondientes a este Dbredb -->
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
                                                                    <input type="radio" class="control-input" name="selected_item_id" value="{{ $item->id }}">
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
                                                    <input type="text" class="form-control" name="articulo_caa">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="analisis">Analisis:</label>
                                                    <input type="file" class="form-control" name="analisis" id="analisis">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="ingredientes">Ingredientes:</label>
                                                    <input type="file" class="form-control" name="ingredientes" id="ingredientes">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="especificaciones">Especificaciones técnicas:</label>
                                                    <input type="file" class="form-control" name="especificaciones" id="especificaciones">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="monografia">Monografia e informacion nutricional:</label>
                                                    <input type="file" class="form-control" name="monografia" id="monografia">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="rotulo">Rótulo:</label>
                                                    <input type="file" class="form-control" name="rotulo" id="rotulo">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="certenvase">Certificado de envase de uso alimentario:</label>
                                                    <input type="file" class="form-control" name="certenvase" id="certenvase">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="plano">Comprobante de pago:</label>
                                                    <input type="file" class="form-control" name="pago" id="pago">
                                                    <small class="form-text text-danger">*Requerido.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12 text-center">
                                        <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                                            <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit" name="submit">
                                                <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                Ingresar
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
@endsection
