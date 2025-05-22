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
                    <div class="card bg-gradient-default mt-1 mb-1" style="margin: 0.5rem 0;">
                        <div class="card-body">
                            <nav class="navbar navbar-left navbar navbar-dark" id="navbar-main">
                                <div class="container-fluid">
                                <h2 style = "color: white">Buscador</h2>
                                {{ Form::open(['route' => 'lab_muestras_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group mr-2 mb-2">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('numero', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Número', 'style' => 'height: 1.5rem;']) }}
                                        </div>
                                    </div>
                                    @if ((Auth::user()->departamento_id == 1) || (Auth::user()->departamento_id == 5) || (Auth::user()->id == 30))
                                    <div class="form-group mr-2 mb-2">
                                        <div class="input-group input-group-alternative">
                                        <select class="chosen-select" name="departamento">
                                            <option disabled selected>Dpto</option>
                                            @foreach($departamentos as $departamento)
                                            <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    @endif
                                    @if (Auth::user()->id == 2)
                                    <div class="form-group mr-2 mb-2">
                                        <div class="input-group input-group-alternative">
                                        <select class="chosen-select" name="cargada">
                                            <option disabled selected>Estado</option>
                                            <option value="1">Para Firmar</option>
                                            <option value="0">No Salidas/Firmadas</option>
                                        </select>
                                        </div>
                                    </div>
                                    @endif
                                    @if (Auth::user()->departamento_id <> 6)
                                    <div class="form-group mr-2 mb-2">
                                        <div class="input-group input-group-alternative">
                                        <select class="chosen-select" name="remitente" style="width:300px">
                                            <option disabled selected>Remitente</option>
                                            @foreach($remitentes as $remitente)
                                            <option value="{{$remitente->id}}">{{$remitente->nombre}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group mr-2">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('muestra', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Muestra', 'size'=>'45x5', 'style' => 'height: 1.5rem;']) }}
                                        </div>
                                    </div>

                                    <div class="form-group mr-2">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('identificacion', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Identificación', 'style' => 'height: 1.5rem;']) }}
                                        </div>
                                    </div>
                                    <div class="form-group mr-2">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('lugar_extraccion', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Lugar Extracción', 'style' => 'height: 1.5rem;']) }}
                                        </div>
                                    </div>
                                    <div class="form-group mr-2">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="form-control form-control-sm" style="height: 1.5rem;"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('lote', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Lote', 'style' => 'height: 1.5rem;']) }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h3 style="color: white;">Fecha de entrada</h3>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fecha_entrada_inicio" class="control-label" style="color: white; margin-right: 10px">Desde:</label>
                                                {{ Form::date('fecha_entrada_inicio', null, ['class' => 'form-control form-control-sm']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fecha_entrada_inicio" class="control-label" style="color: white; margin-right: 10px">Hasta:</label>
                                                {{ Form::date('fecha_entrada_final', null, ['class' => 'form-control form-control-sm']) }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mr-1">
                                        <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm">
                                        <i class="fas fa-search fa-lg"></i>
                                        </button>
                                    </div>
                                    <div class="form-group mr-1">
                                            <button type="submit" class="btn btn-secondary btn-fab btn-fab-mini btn-round btn-sm" href="{{ route('lab_muestras_index') }}">
                                            <i class="fas fa-redo fa-lg"></i>
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
                                <h2 class="mb-0" style="color:white">Muestras</h2>
                            </div>
                            <div class="col text-right">
                            <a href="#" class="btn btn-sm btn-success btn-close" data-toggle="modal" data-target="#agregaranio">Consultas Muestras en EXCEL</a>
                                <a href="{{ route('lab_muestras_create') }}" class="btn btn-sm btn-primary">Nueva Muestra</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Número</th>
                                    <th scope="col">Muestra</th>
                                    @if ((Auth::user()->departamento_id == 2) || (Auth::user()->departamento_id == 3))
                                    <th scope="col">Remite</th>
                                    @elseif (Auth::user()->departamento_id == 4)
                                    <th scope="col">Remite</th>
                                    <th scope="col" class="text-center">Área</th>
                                    @elseif ((Auth::user()->departamento_id <> 4) && (Auth::user()->role_id <> 13))
                                    <th scope="col" class="text-center">Dpto</th>
                                    <th scope="col" class="text-center">Área</th>
                                    @else
                                    @endif
                                    @if (Auth::user()->departamento_id <> 1)
                                    <th scope="col" class="text-center">Fecha Ingreso</th>
                                    @else
                                    @endif
                                    <th scope="col">Salida</th>
                                    <th scope="col" style="width:10%">Firma</th>
                                    <th scope="col" style="width:10%">Condicion</th>
                                    @if (((Auth::user()->role_id == 1) || (Auth::user()->role_id == 2)) || (Auth::user()->departamento_id == 5))
                                    <th scope="col" style="width:10%">Factura</th>
                                    @else
                                    @endif
                                    @if (Auth::user()->departamento_id == 1)
                                    <th scope="col" class="text-right">Opciones</th>
                                    @else
                                    @endif
                                    @if (Auth::user()->role_id == 13)
                                    <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($muestras as $muestra)
                                                <tr>
                                                    <form action="{{ route('lote') }}" method="POST">
                                                    @csrf
                                                    <td style="width:1px"><input type="checkbox" class="control-input" id="selected" name="selected[]" value="{{ $muestra->id }}"></td>
                                                    <td style="width:20px"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}">{{ $muestra->numero}}</a></td>
                                                    <td style="width: 130px"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}"><strong>{{ $muestra->matriz->matriz }} /</strong>
                                                        {{ str_limit($muestra->muestra, 20)}}</a>
                                                    </td>
                                                    @if ((Auth::user()->departamento_id == 2) || (Auth::user()->departamento_id == 3))
                                                    <td style="width:20%"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}">{{ str_limit($muestra->remitente->nombre, 20)}}</a></td>
                                                    @elseif (Auth::user()->departamento_id == 4)
                                                    <td style="width:20%"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}">{{ str_limit($muestra->remitente->nombre, 20)}}</a></td>
                                                    <td style="width:20px" class="text-center">
                                                        @if (!is_null($muestra->microbiologia))
                                                        <h6><span class="badge badge-pill badge-info">M</span></h6>
                                                        @endif
                                                        @if (!is_null($muestra->quimica))
                                                        <h6><span class="badge badge-pill badge-info">Q</span></h6>
                                                        @endif
                                                        @if (!is_null($muestra->cromatografia))
                                                        <h6><span class="badge badge-pill badge-info">C</span></h6>
                                                        @endif
                                                        @if (!is_null($muestra->ensayo_biologico))
                                                        <h6><span class="badge badge-pill badge-info">EB</span></h6>
                                                        @endif
                                                    </td>
                                                    @elseif (Auth::user()->departamento_id == 1 || Auth::user()->departamento_id == 5)
                                                    <td style="width:20px" class="text-center">
                                                        @if ($muestra->departamento_id == 1)
                                                            @if (is_null($muestra->aceptada))
                                                            <h6><span class="badge badge-pill badge-warning">DL</span><h6>
                                                                @elseif ($muestra->aceptada == 0)
                                                                <h6><span class="badge badge-pill badge-danger">DL</span><h6>
                                                                @elseif ($muestra->aceptada == 1)
                                                                <h6><span class="badge badge-pill badge-success">DL</span><h6>
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
                                                        @elseif ($muestra->departamento_id == 6)
                                                            @if (is_null($muestra->aceptada))
                                                                <span class="badge badge-pill badge-warning">Cliente</span>
                                                                @elseif ($muestra->aceptada == 0)
                                                                <span class="badge badge-pill badge-danger">Cliente</span>
                                                                @elseif ($muestra->aceptada == 1)
                                                                <span class="badge badge-pill badge-success">Cliente</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td style="width:20px" class="text-center">
                                                        @php
                                                            $letrasUtilizadas = [];
                                                        @endphp

                                                        @foreach ($muestra->ensayos as $ensayo)
                                                            @if (!in_array($ensayo->tipo_ensayo, $letrasUtilizadas))
                                                            @php
                                                                $letrasUtilizadas[] = $ensayo->tipo_ensayo;
                                                            @endphp

                                                            @if ($ensayo->tipo_ensayo === 'Microbiológico')
                                                                <span class="badge badge-pill badge-info">M</span>
                                                            @elseif ($ensayo->tipo_ensayo === 'Físico/Químico')
                                                                <span class="badge badge-pill badge-info">Q</span>
                                                            @elseif ($ensayo->tipo_ensayo === 'Cromatografía')
                                                                <span class="badge badge-pill badge-info">C</span>
                                                            @elseif ($ensayo->tipo_ensayo === 'Ensayo Biológico')
                                                                <span class="badge badge-pill badge-info">EB</span>
                                                            @endif
                                                            @endif
                                                        @endforeach
                                                    </td>

                                                    @endif
                                                    @if (Auth::user()->departamento_id <> 1)
                                                    <td style="width:20%" class="text-center">{{ date('d-m-Y', strtotime($muestra->fecha_entrada)) }}</td>
                                                    @else
                                                    @endif
                                                    @if (strtotime($muestra->fecha_salida) > 0)
                                                    <td style="width:20px">{{ date('d-m-Y', strtotime($muestra->fecha_salida)) }}</td>
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
                                                        <td style="width:10px" align="center"><span class="fas fa-check fa-2x text-green"></span></td>
                                                        @else
                                                        <td></td>
                                                    @endif
                                                    @if ($muestra->condicion <> 'Sin/Conclusión')
                                                        <td style="width:10px" align="center"><span class="fas fa-check fa-2x text-green"></span></td>
                                                        @else
                                                        <td></td>
                                                    @endif
                                                    @if (((Auth::user()->role_id == 1) || (Auth::user()->role_id == 2)) || (Auth::user()->departamento_id == 5))
                                                        @if ($muestra->factura_id)
                                                        <td style="width:20%"><span class="badge badge-pill badge-success">FACTURADA</span></td>
                                                        @else
                                                            <td style="width:20%"><span class="badge badge-pill badge-danger">NO FACTURADA</span></td>
                                                        @endif
                                                    @else
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
                                                                         @if ($muestra->traducida === 1)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link" href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_traducido')}}" onclick="refresh()" target="_blank">
                                                                                <i class="fas fa-file-signature" style="margin-left:1em"></i> {{ __('Imprimir Resultado Traducido') }}
                                                                            </a>
                                                                        </li>
                                                                        @endif
                                                                    @endif
                                                            </ul>
                                                            </div>
                                                            </div>
                                                            @else
                                                            <div></div>
                                                            @endif
                                                            @if ((Auth::user()->departamento_id == 2) || (Auth::user()->departamento_id == 3) || (Auth::user()->departamento_id == 4) || (Auth::user()->departamento_id == 6))
                                                            @if ($muestra->revisada === 1)
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
                            <div class="col text-left" style="margin-bottom: 10px;">
                            <input type="checkbox" id="select-all">
                                <label for="select-all" style="color: white;margin-left: 10px;margin-right: 30px;">Seleccionar todos</label>
                            @if (Auth::user()->departamento_id <> 6)
                                <button type="submit" name="action" value="generarFactura" class="btn btn-sm btn-info">Generar factura</button>
                            @endif
                            @if ((Auth::user()->departamento_id == 1) && (Auth::user()->role_id == 1))
                                <button type="submit" name="action" value="batchAction" class="btn btn-sm btn-info">Revisar seleccionadas</button>
                            @endif
                            </div>
                            </form>
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-center" style="margin-top:2em">
                        {{ $muestras->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    @include('layouts.footers.auth')
    </div>

<!-- Modal -->

<div class="modal fade" id="agregaranio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Consulta de muestras por año</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>
        @if (Auth::user()->departamento_id == 1)
            <form action="{{ route('dl.excel') }}" method="GET">
        @elseif (Auth::user()->departamento_id == 2)
            <form action="{{ route('db.excel') }}" method="GET">
        @elseif (Auth::user()->departamento_id == 3)
            <form action="{{ route('dsb.excel') }}" method="GET">
        @elseif (Auth::user()->departamento_id == 4)
            <form action="{{ route('dso.excel') }}" method="GET">
        @elseif (Auth::user()->departamento_id == 6)
            <form action="{{ route('cliente.excel') }}" method="GET">
        @endif
        <input type="hidden" name="year" value="{{ $year }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="year">Elegir año</label>
                    <select class="form-control" name="year" id="year">
                        @for ($i = date('Y'); $i >= 2018; $i--)
                            <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <i></i>
                </div>                                            
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="enviarBtn">Enviar</button>
              </div>
              <div id="div" class="alert alert-success" style="display:none;">
                <p id="textoEsp" style="display:none; margin: 20px;">Espere unos segundos a que aparezca la ventana para guardar el archivo, el tiempo demorara según la cantidad de informacion que contenga el año consultado.</p>
              </div>
        </form>
    </div>
  </div>
</div>
    <script>
        function refresh() {
        setTimeout(function(){
        window.location.reload();
        }, 1000);
        }
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="selected[]"]');
        
        selectAll.addEventListener('click', function() {
            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAll.checked;
            });
        });
    </script>
        <script>
        document.getElementById("enviarBtn").addEventListener("click", function() {
            document.getElementById("div").style.display = "block";
            document.getElementById("textoEsp").style.display = "block";
            setTimeout(function() {
                    $("#agregaranio").modal("hide");
            }, 10000);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#agregaranio').on('hidden.bs.modal', function () {
            $('#textoEsp').hide();
            });
        });
    </script>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush