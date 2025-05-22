@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.notas.index', 'title' => __('Sistema DPSA')])

@section('content')
<div class="header bg-primary pb-8 pt-5 pt-md-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="content">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                <div class="row">
                    <div class="card">
                        <div class="card text-white bg-gradient-default mt-3 mb-1 mb-lg-0">
                            <h4 class="card-title">Notas ingresadas</h4>
                            <a href="{{ route('lab_notas_create') }}" class="btn btn-default btn-sm ml-auto">Nuevo</a>
                        </div>
                            <div class="card-header">
                                <h4>Busqueda de notas</h4>
                                {{ Form::open(['route' => 'lab_notas_index', 'method' => 'GET', 'class' => 'form-inline pull-left']) }}
                                <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-1">
                                                {{ Form::text('numero', null, ['class' => 'form-control', 'placeholder' => 'Número']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-1">
                                                {{ Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                                <i class="material-icons">search</i>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-fab btn-fab-mini btn-round" href="{{ route('lab_notas_index') }}">
                                                <i class="material-icons">refresh</i>
                                            </button>
                                        </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                                <div class="card-body">
                                    <div class="tab-pane active" id="profile">                 
                                    <table class="table">
                                            <thead>
                                                <tr><strong>
                                                    <th class="text-center">Número</th>
                                                    <th>Fecha</th>
                                                    <th>Descripción</th>
                                                    <th>Opciones</th>
                                                </strong>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dlnotas as $dlnota)
                                                <tr>
                                                    <td class="text-center">{{ $dlnota->numero}}</td>
                                                    <td>{{ date('d-m-Y', strtotime($dlnota->fecha)) }}</td>
                                                    <td>{{ $dlnota->descripcion}}</td>
                                                    <td class="td-actions text-left">
                                                        <a href="{{ url('/lab/notas/'.$dlnota->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round">
                                                            <i class="material-icons">edit</i>
                                                        </a>                                 
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                                {{ $dlnotas->links() }}
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>
        </div>
    </div>
</div>


@endsection
