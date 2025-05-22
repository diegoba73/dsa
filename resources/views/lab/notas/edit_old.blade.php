@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.notas.edit', 'title' => __('Sistema DPSA')])
@section('content')
<div class="container" style="height: auto;">
                <div class="card-body">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                </div>

                    <div class="row">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">Editar Nota</h4>
                                    <p class="card-category">Completar los datos</p>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ url('/lab/notas/'.$dlnota->id.'/edit') }}">
                                    {{ csrf_field() }}
                                    <input name="url" type="hidden" value="{{ $url }}">
                                        <div class="form-group">
                                            <label class="label-control">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" value="{{ $dlnota->fecha }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Descripción:</label>
                                            <input type="text" class="form-control" name="descripcion" value="{{ $dlnota->descripcion }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary pull-center button-prevent-multiple-submit">
                                                    <i class="spinner fa fa-spinner fa-spin" style="display:none;"></i>
                                                    Ingresar
                                        </button>
                                    </form>
                                </div>
                            </div>
                    </div>

</div>   
@endsection