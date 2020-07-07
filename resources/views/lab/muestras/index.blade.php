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
                <!-- Card stats -->
                <div class="card text-white bg-gradient-default mt-0 mb-2 mb-lg-1">
                <div class="row">
                    @if (Auth::user()->departamento_id == 1)
                    <div class="col-xl-3 col-lg-4">
                        <div class="card card-stats mr-2 ml-4 mb-4 mt-4">
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Departamento Laboratorio</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$dl_t->count()}} Totales</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2"> {{$dl->count()}}</span>
                                    <span class="text-nowrap">Pendientes</span>
                                    <span>(</span><span class="text-warning mr-2"> {{$dl_m->count()}}</span>
                                    <span class="text-nowrap">M | </span>
                                    <span class="text-warning mr-2"> {{$dl_q->count()}}</span>
                                    <span class="text-nowrap">Q | </span>
                                    <span class="text-warning mr-2"> {{$dl_c->count()}}</span>
                                    <span class="text-nowrap">C | </span>
                                    <span class="text-warning mr-2"> {{$dl_eb->count()}}</span>
                                    <span class="text-nowrap">EB</span><span>)</span>
                                </p>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2"> {{$dl_r->count()}}</span>
                                    <span class="text-nowrap">Rechazadas</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                    <div class="card card-stats mr-2 ml-4 mb-4 mt-4">
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Departamento Bromatología</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$db_t->count()}} Totales</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2">{{$db->count()}}</span>
                                    <span class="text-nowrap">Pendientes</span>
                                    <span>(</span><span class="text-warning mr-2"> {{$db_m->count()}}</span>
                                    <span class="text-nowrap">M | </span>
                                    <span class="text-warning mr-2"> {{$db_q->count()}}</span>
                                    <span class="text-nowrap">Q | </span>
                                    <span class="text-warning mr-2"> {{$db_c->count()}}</span>
                                    <span class="text-nowrap">C | </span>
                                    <span class="text-warning mr-2"> {{$db_eb->count()}}</span>
                                    <span class="text-nowrap">EB</span><span>)</span>
                                </p>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2">{{$db_r->count()}}</span>
                                    <span class="text-nowrap">Rechazadas</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                    <div class="card card-stats mr-2 ml-4 mb-4 mt-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                    
                                        <h5 class="card-title text-uppercase text-muted mb-0">Dpto. Saneamiento Básico</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$dsb_t->count()}} Totales</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2">{{$dsb->count()}}</span>
                                    <span class="text-nowrap">Pendientes</span>
                                    <span>(</span><span class="text-warning mr-2"> {{$dsb_m->count()}}</span>
                                    <span class="text-nowrap">M | </span>
                                    <span class="text-warning mr-2"> {{$dsb_q->count()}}</span>
                                    <span class="text-nowrap">Q | </span>
                                    <span class="text-warning mr-2"> {{$dsb_c->count()}}</span>
                                    <span class="text-nowrap">C | </span>
                                    <span class="text-warning mr-2"> {{$dsb_eb->count()}}</span>
                                    <span class="text-nowrap">EB</span><span>)</span>
                                </p>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2">{{$dsb_r->count()}}</span>
                                    <span class="text-nowrap">Rechazadas</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-2">                    
                    <div class="card card-stats mr-4 ml-4 mb-4 mt-4">
                            <div class="card-body">
                                <div class="row">
                                
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Dpto. Salud Ocupacional</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$dso_t->count()}} Totales</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2">{{$dso->count()}}</span>
                                    <span class="text-nowrap">Pendientes</span>
                                    <span>(</span><span class="text-warning mr-2"> {{$dso_m->count()}}</span>
                                    <span class="text-nowrap">M | </span>
                                    <span class="text-warning mr-2"> {{$dso_q->count()}}</span>
                                    <span class="text-nowrap">Q | </span>
                                    <span class="text-warning mr-2"> {{$dso_c->count()}}</span>
                                    <span class="text-nowrap">C | </span>
                                    <span class="text-warning mr-2"> {{$dso_eb->count()}}</span>
                                    <span class="text-nowrap">EB</span><span>)</span>
                                </p>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2">{{$dso_r->count()}}</span>
                                    <span class="text-nowrap">Rechazadas</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @elseif (Auth::user()->departamento_id == 2)
                    <div class="col-xl-3 col-lg-4">
                    <div class="card card-stats mr-2 ml-4 mb-4 mt-4">
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Departamento Bromatología</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$db_t->count()}} Totales</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i>{{$db->count()}}</span>
                                    <span class="text-nowrap">Pendientes</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @elseif (Auth::user()->departamento_id == 3)
                    <div class="col-xl-3 col-lg-4">
                    <div class="card card-stats mr-2 ml-4 mb-4 mt-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                    
                                        <h5 class="card-title text-uppercase text-muted mb-0">Dpto. Saneamiento Básico</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$dsb_t->count()}} Totales</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2">{{$dsb->count()}}</span>
                                    <span class="text-nowrap">Pendientes</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @elseif (Auth::user()->departamento_id == 4)
                    <div class="col-xl-3 col-lg-2">                    
                    <div class="card card-stats mr-4 ml-4 mb-4 mt-4">
                            <div class="card-body">
                                <div class="row">
                                
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Dpto. Salud Ocupacional</h5>
                                        <span class="h2 font-weight-bold mb-0">{{$dso_t->count()}} Totales</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2">{{$dso->count()}}</span>
                                    <span class="text-nowrap">Pendientes</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                </div>
                
                <!-- Buscador -->
                <div class="card bg-gradient-default mt-3 mb-2 mb-lg-0">
                <div class="card-body">
                <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                    <div class="container-fluid">
                    <h2 style = "color: white">Buscador</h2>
                    {{ Form::open(['route' => 'lab_muestras_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="input-group input-group-alternative mr-2">
                                <div class="input-group-prepend">
                                    <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                                </div>
                                {{ Form::text('numero', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número', 'size'=>'10x5']) }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group input-group-alternative mr-2">
                                <div class="input-group-prepend">
                                    <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                                </div>
                                {{ Form::text('muestra', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Muestra', 'size'=>'70x5']) }}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group input-group-alternative mr-2">
                            <select class="chosen-select" name="remitente" style="width:400px">
                                <option disabled selected>Remitente</option>
                                @foreach($remitentes as $remitente)
                                <option value="{{$remitente->id}}">{{$remitente->nombre}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    @if ((Auth::user()->departamento_id == 1) || (Auth::user()->departamento_id == 5))
                        <div class="col-sm-3">
                            <div class="input-group input-group-alternative">
                            <select class="chosen-select" name="departamento">
                                <option disabled selected>Departamento</option>
                                @foreach($departamentos as $departamento)
                                <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div> 
                        @endif
                        <div class="col-sm-9">
                            <div class="input-group input-group-alternative mr-4">
                                    <div class="input-group-prepend">
                                        <span class="form-control form-control-sm"><i class="fas fa-search"></i></span>
                                    </div>
                                    {{ Form::text('lugar_extraccion', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Lugar Extracción', 'size'=>'50x5']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    @if ((Auth::user()->departamento_id == 1) || (Auth::user()->departamento_id == 5))
                        <div class="col-sm-4">
                             Cromatografía: {!! Form::checkbox('cromatografia', true, NULL, ['class' => 'checkbox']) !!}
                        </div>
                        <div class="col-sm-4">
                             Química: {!! Form::checkbox('quimica', true, NULL, ['class' => 'checkbox']) !!}
                        </div>
                        <div class="col-sm-4">
                            Ensayo Biol.: {!! Form::checkbox('ensayo_biologico', true, NULL, ['class' => 'checkbox']) !!}
                        </div>
                        <div class="col-sm-4">
                            Micro.: {!! Form::checkbox('microbiologia', true, NULL, ['class' => 'checkbox']) !!}
                        </div>
                        <div class="col-sm-4">
                        Pendientes: {{ Form::checkbox('pendiente', $pendiente, null, ['class' => 'form-check-input']) }}
                        </div>
                        @else
                        <div class="col-sm-12 mr-9">
                        </div>
                        <div class="col-sm-12 mr-9">
                        </div>
                        <div class="col-sm-12 mr-9">
                        </div>
                        <div class="col-sm-12 mr-9">
                        </div>
                    @endif
                    </div>

                    <div class="row align-items-end ml-6">
                        <div class="col">
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round">
                            <i class="fas fa-search"></i>
                            </button>
                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round" href="{{ route('lab_muestras_index') }}">
                                <i class="fas fa-redo"></i>
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                    </div>
                </nav>
                </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid mt--8">
        <div class="row mt-9">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-gradient-default border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0" style="color:white">Muestras</h3>
                            </div>
                            @if (Auth::user()->departamento_id == 5)
                            <div></div>
                            @else
                            <div class="col text-right">
                            @if (Auth::user()->departamento_id == 1)
                            <a href="{{ route('dl.excel') }}" class="btn btn-sm btn-secondary">Consultas Muestras en EXCEL</a>
                            @elseif (Auth::user()->departamento_id == 2)
                            <a href="{{ route('db.excel') }}" class="btn btn-sm btn-secondary">Consultas Muestras en EXCEL</a>
                            @elseif (Auth::user()->departamento_id == 3)
                            <a href="{{ route('dsb.excel') }}" class="btn btn-sm btn-secondary">Consultas Muestras en EXCEL</a>
                            @elseif (Auth::user()->departamento_id == 4)
                            <a href="{{ route('dso.excel') }}" class="btn btn-sm btn-secondary">Consultas Muestras en EXCEL</a>
                            @endif
                                <a href="{{ route('lab_muestras_create') }}" class="btn btn-sm btn-primary">Nueva Muestra</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Número</th>
                                    <th scope="col">Muestra</th>
                                    @if ((Auth::user()->departamento_id == 2) || (Auth::user()->departamento_id == 3))
                                    <th scope="col">Remite</th>
                                    @elseif (Auth::user()->departamento_id == 4)
                                    <th scope="col">Remite</th>
                                    <th scope="col" class="text-center">Área</th>
                                    @else
                                    <th scope="col" class="text-center">Departamento</th>
                                    <th scope="col" class="text-center">Área</th>
                                    @endif
                                    <th scope="col">Fecha de Salida</th>
                                    <th scope="col">Firma Digital</th>
                                    <th scope="col" class="text-right">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($muestras as $muestra)
                                                <tr>
                                                    <td style="width:20px"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}">{{ $muestra->numero}}</a></td>
                                                    <td style="width: 130px"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}"><strong>{{ $muestra->matriz->matriz }} /</strong>
                                                        {{ str_limit($muestra->muestra, 30)}}</a>
                                                    </td>
                                                    @if ((Auth::user()->departamento_id == 2) || (Auth::user()->departamento_id == 3))
                                                    <td style="width:20%"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}">{{ $muestra->remitente->nombre}}</a></td>
                                                    @elseif (Auth::user()->departamento_id == 4)
                                                    <td style="width:20%"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}">{{ $muestra->remitente->nombre}}</a></td>
                                                    <td style="width:20px" class="text-center">
                                                        @if (!is_null($muestra->microbiologia))
                                                        <span class="badge badge-pill badge-info">M</span>
                                                        @endif
                                                        @if (!is_null($muestra->quimica))
                                                        <span class="badge badge-pill badge-info">Q</span>
                                                        @endif
                                                        @if (!is_null($muestra->cromatografia))
                                                        <span class="badge badge-pill badge-info">C</span>
                                                        @endif
                                                        @if (!is_null($muestra->ensayo_biologico))
                                                        <span class="badge badge-pill badge-info">EB</span>
                                                        @endif
                                                    </td>
                                                    @elseif (Auth::user()->departamento_id == 1 || Auth::user()->departamento_id == 5)
                                                    <td style="width:20px" class="text-center">
                                                        @if ($muestra->departamento_id == 1)
                                                            @if (is_null($muestra->aceptada))
                                                            <span class="badge badge-pill badge-warning">DL</span>
                                                                @elseif ($muestra->aceptada == 0)
                                                                <span class="badge badge-pill badge-danger">DL</span>
                                                                @elseif ($muestra->aceptada == 1)
                                                                <span class="badge badge-pill badge-success">DL</span>
                                                            @endif
                                                        @elseif ($muestra->departamento_id == 3)
                                                            @if (is_null($muestra->aceptada))
                                                            <span class="badge badge-pill badge-warning">DSB</span>
                                                                @elseif ($muestra->aceptada == 0)
                                                                <span class="badge badge-pill badge-danger">DSB</span>
                                                                @elseif ($muestra->aceptada == 1)
                                                                <span class="badge badge-pill badge-success">DSB</span>
                                                            @endif
                                                        @elseif ($muestra->departamento_id == 4)
                                                            @if (is_null($muestra->aceptada))
                                                                <span class="badge badge-pill badge-warning">DSO</span>
                                                                @elseif ($muestra->aceptada == 0)
                                                                <span class="badge badge-pill badge-danger">DSO</span>
                                                                @elseif ($muestra->aceptada == 1)
                                                                <span class="badge badge-pill badge-success">DSO</span>
                                                            @endif
                                                        @elseif ($muestra->departamento_id == 2)
                                                            @if (is_null($muestra->aceptada))
                                                                <span class="badge badge-pill badge-warning">DB</span>
                                                                @elseif ($muestra->aceptada == 0)
                                                                <span class="badge badge-pill badge-danger">DB</span>
                                                                @elseif ($muestra->aceptada == 1)
                                                                <span class="badge badge-pill badge-success">DB</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td style="width:20px" class="text-center">
                                                        @if (!is_null($muestra->microbiologia))
                                                        <span class="badge badge-pill badge-info">M</span>
                                                        @endif
                                                        @if (!is_null($muestra->quimica))
                                                        <span class="badge badge-pill badge-info">Q</span>
                                                        @endif
                                                        @if (!is_null($muestra->cromatografia))
                                                        <span class="badge badge-pill badge-info">C</span>
                                                        @endif
                                                        @if (!is_null($muestra->ensayo_biologico))
                                                        <span class="badge badge-pill badge-info">EB</span>
                                                        @endif
                                                    </td>
                                                    @endif
                                                    @if (strtotime($muestra->fecha_salida) > 0)
                                                    <td style="width:20%">{{ date('d-m-Y', strtotime($muestra->fecha_salida)) }}</td>
                                                    @else
                                                    @if (is_null($muestra->aceptada))
                                                        <td style="width:20%"><span class="badge badge-pill badge-warning">SIN SALIDA</span></td>
                                                        @elseif ($muestra->aceptada == 0)
                                                        <td style="width:20%"><span class="badge badge-pill badge-danger">SIN SALIDA</span></td>
                                                        @elseif ($muestra->aceptada == 1)
                                                        <td style="width:20%"><span class="badge badge-pill badge-success">SIN SALIDA</span></td>
                                                    @endif
                                                    @endif
                                                    @if ($muestra->revisada === 1)
                                                        <td style="width:10%" align="center"><span class="fas fa-check fa-2x text-green"></span></td>
                                                        @else
                                                        <td></td>
                                                    @endif
                                                    <td class="text-right">
                                                        @if (Auth::user()->departamento_id == 1)
                                                        <div class="dropdown">
                                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-center dropdown-menu-arrow">
                                                            <ul class="navbar-nav" align="left">
                                                                    @if (($muestra->revisada === null) || ($muestra->revisada === 0))                                               
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="{{ route('devolver_muestra', $muestra->id) }}">
                                                                            <i class="far fa-arrow-alt-circle-left text-primary" style="margin-left:1em"></i> {{ __('Devolver') }}
                                                                        </a>
                                                                    </li>
                                                                        @if ($muestra->aceptada === null)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ route('aceptar_muestra', $muestra->id) }}">
                                                                                <i class="fas fa-check-circle text-primary" style="margin-left:1em"></i> {{ __('Aceptar') }}
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ route('lab_muestras_rechazo', $muestra->id) }}">
                                                                                <i class="fas fa-times-circle text-blue" style="margin-left:1em"></i> {{ __('Rechazar') }}
                                                                            </a>
                                                                        </li>
                                                                        @elseif ($muestra->aceptada === 0)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ route('aceptar_muestra', $muestra->id) }}">
                                                                                <i class="fas fa-check-circle text-primary" style="margin-left:1em"></i> {{ __('Aceptar') }}
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ route('lab_muestras_rechazo', $muestra->id) }}">
                                                                                <i class="fas fa-times-circle text-blue" style="margin-left:1em"></i> {{ __('Formulario Rechazo') }}
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_rechazo')}}" onclick="refresh()" target="_blank">
                                                                                <i class="fas fa-print text-blue" style="margin-left:1em"></i> {{ __('Imprimir Rechazo') }}
                                                                            </a>
                                                                        </li>
                                                                        @elseif ($muestra->aceptada === 1)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ route('lab_muestras_rechazo', $muestra->id) }}">
                                                                                <i class="fas fa-times-circle text-blue" style="margin-left:1em"></i> {{ __('Rechazar') }}
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ url('/lab/muestras/'.$muestra->id.'/ht')}}" target="_blank">
                                                                                <i class="fas fa-file-alt text-blue" style="margin-left:1em"></i> {{ __('Hoja de Trabajo') }}
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ route('lab_muestras_resultado', $muestra->id) }}">
                                                                                <i class="fas fa-file-contract text-blue" style="margin-left:1em"></i> {{ __('Resultado') }}
                                                                            </a>
                                                                        </li>
                                                                        @endif
                                                                        @if ($muestra->cargada === 1)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado')}}" onclick="refresh()" target="_blank">
                                                                                <i class="fas fa-print text-blue" style="margin-left:1em"></i> {{ __('Imprimir Resultado') }}
                                                                            </a>
                                                                        </li>
                                                                        @endif
                                                                    @endif
                                                                    @if ($muestra->revisada === 1)                                             
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado')}}" onclick="refresh()" target="_blank">
                                                                                <i class="fas fa-print text-blue" style="margin-left:1em"></i> {{ __('Imprimir Resultado') }}
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado_firma')}}" onclick="refresh()" target="_blank">
                                                                                <i class="fas fa-file-signature" style="margin-left:1em"></i> {{ __('Imprimir Resultado Firmado') }}
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                            </ul>
                                                            </div>
                                                            </div>
                                                            @else
                                                            <div></div>
                                                            @endif
                                                            @if ((Auth::user()->departamento_id == 2) || (Auth::user()->departamento_id == 3) || (Auth::user()->departamento_id == 4))
                                                            @if (($muestra->revisada === 1) && (Auth::user()->role_id === 1))
                                                            <div class="dropdown">
                                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-center dropdown-menu-arrow">
                                                            <ul class="navbar-nav" align="left">
                                                                    
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado_firma')}}" onclick="refresh()" target="_blank">
                                                                                <i class="fas fa-file-signature" style="margin-left:1em"></i> {{ __('Imprimir Resultado Firmado') }}
                                                                            </a>
                                                                        </li>
                                                                    
                                                            </ul>
                                                            </div>
                                                            </div>
                                                            @endif
                                                            @endif
                                                    </td>
                                                   
                                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:6em">
                        {{ $muestras->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
    <script>
function refresh() {
setTimeout(function(){
   window.location.reload();
}, 1000);
}
</script>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush