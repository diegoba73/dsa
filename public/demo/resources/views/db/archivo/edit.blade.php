@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'db.archivo.edit', 'title' => __('Sistema DPSA')])
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
                                    <strong class="card-title">Editar datos del Archivo</strong>
                                </div>
                                <div class="card-body">
                                    <form class="form-group form-prevent-multiple-submit" method="post" action="{{ url('/db/archivo/'.$dbarchivo->id.'/edit') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="label-control">Caja:</label>
                                            <input type="text" class="form-control" name="caja" value="{{ $dbarchivo->caja }}">
                                        </div>
                                    </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Establecimiento:</label>
                                            <input type="text" class="form-control" name="establecimiento" value="{{ $dbarchivo->establecimiento }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Descripción:</label>
                                            <input type="text" class="form-control" name="descripcion" value="{{ $dbarchivo->descripcion }}">
                                        </div>
                                        <a class="btn btn-default btn-close" href="{{ route('db_archivo_index') }}">Cancelar</a>
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