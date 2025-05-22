@extends('layouts.app')

@section('content')
<div class="header bg-primary pb-1 pt-5 pt-md-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="content">
                @if (session('notification'))
                    <div class="alert alert-success">
                        {{ session('notification') }}
                    </div>
                @endif
                @if (session('danger'))
                    <div class="alert alert-danger">{{ session('danger') }}</div>
                @endif
                <!-- Buscador -->
                <div class="card bg-gradient-default mt-3 mb-2 mb-lg-0">
                <div class="card-body">
                <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                    <div class="container-fluid">
                    <h2 style = "color: white">Buscador</h2>
                    {{ Form::open(['route' => 'db_dt_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('dni', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'DNI']) }}
                        </div>
                    </div>
                    <div class="form-group mr-5">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                            </div>
                            {{ Form::text('nombre', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Nombre']) }}
                        </div>
                    </div>
                    
                    <div class="form-group mr-1">
                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="form-group mr-1">
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('lab_ensayos_index') }}">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                    {{ Form::close() }}
                    </div>
                </nav>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-2">
    <div class="row mt-2">
        <div class="col-xl-12 mb-2 mb-xl-0">
            <div class="card bg-gradient-default shadow">
                <div class="card-header bg-gradient-default border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="mb-0" style="color:white">Directores Técnicos</h2>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('db_dt_create') }}" class="btn btn-sm btn-primary">Nuevo DT</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped align-items-center table-dark">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">DNI</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dbdts as $dbdt)
                            <tr>
                                <td><a class="text-white" href="#">{{ $dbdt->id }}</a></td>
                                <td><a class="text-white" href="{{ route('db_dt_show', $dbdt) }}" target="_blank"><strong>{{ $dbdt->nombre }}</strong></a></td>
                                <td><a class="text-white" href="#">{{ $dbdt->dni }}</a></td>
                                <td><a class="text-white" href="#">{{ $dbdt->ciudad }}</a></td>
                                <td class="td-actions text-left">
                                    <a href="{{ route('db_dt_edit', $dbdt) }}" title="Editar" rel="tooltip" class="btn btn-primary btn-round btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <ul class="pagination justify-content-center" style="margin-top:2em">
                        {{ $dbdts->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection