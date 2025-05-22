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
                    <div class="card bg-gradient-default mt-1 mb-1">
                        <div class="card-body">
                            <h5 class="text-white mb-3">Filtros de búsqueda</h5>
                            {{ Form::open(['route' => 'lab_muestras_index', 'method' => 'GET', 'class' => 'form']) }}
                                <div class="form-row">
                                    {{-- Número --}}
                                    <div class="form-group col-md-2">
                                        <label class="text-white">Número</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('numero', null, ['class' => 'form-control', 'placeholder' => 'Número']) }}
                                        </div>
                                    </div>

                                    {{-- Departamento --}}
                                    @if ((Auth::user()->departamento_id == 1) || (Auth::user()->departamento_id == 5) || (Auth::user()->id == 30))
                                    <div class="form-group col-md-2">
                                        <label class="text-white">Departamento</label>
                                        <select class="form-control chosen-select form-control-sm" name="departamento">
                                            <option disabled selected>Dpto</option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                    {{-- Estado --}}
                                    @if (Auth::user()->id == 2)
                                    <div class="form-group col-md-2">
                                        <label class="text-white">Estado</label>
                                        <select class="form-control form-control-sm" name="cargada">
                                            <option disabled selected>Estado</option>
                                            <option value="1">Para Firmar</option>
                                            <option value="0">No Salidas/Firmadas</option>
                                        </select>
                                    </div>
                                    @endif

                                    {{-- Remitente --}}
                                    @if (Auth::user()->departamento_id <> 6)
                                    <div class="form-group col-md-3">
                                        <label class="text-white">Remitente</label>
                                        <select class="form-control chosen-select form-control-sm" name="remitente">
                                            <option disabled selected>Remitente</option>
                                            @foreach($remitentes as $remitente)
                                                <option value="{{$remitente->id}}">{{$remitente->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                    {{-- Muestra --}}
                                    <div class="form-group col-md-3">
                                        <label class="text-white">Muestra</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('muestra', null, ['class' => 'form-control', 'placeholder' => 'Muestra']) }}
                                        </div>
                                    </div>

                                    {{-- Identificación --}}
                                    <div class="form-group col-md-3">
                                        <label class="text-white">Identificación</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('identificacion', null, ['class' => 'form-control', 'placeholder' => 'Identificación']) }}
                                        </div>
                                    </div>

                                    {{-- Lote --}}
                                    <div class="form-group col-md-2">
                                        <label class="text-white">Lote</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('lote', null, ['class' => 'form-control', 'placeholder' => 'Lote']) }}
                                        </div>
                                    </div>

                                    {{-- Lugar de extracción --}}
                                    <div class="form-group col-md-3">
                                        <label class="text-white">Lugar Extracción</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            {{ Form::text('lugar_extraccion', null, ['class' => 'form-control', 'placeholder' => 'Lugar']) }}
                                        </div>
                                    </div>

                                    {{-- Fecha desde / hasta --}}
                                    <div class="form-group col-md-4">
                                        <label class="text-white">Fecha de entrada (Desde / Hasta)</label>
                                        <div class="d-flex align-items-center">
                                            {{ Form::date('fecha_entrada_inicio', null, ['class' => 'form-control form-control-sm mr-2']) }}
                                            <span class="text-white">→</span>
                                            {{ Form::date('fecha_entrada_final', null, ['class' => 'form-control form-control-sm ml-2']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-2 text-right">
                                    <button type="submit" class="btn btn-sm btn-light">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    <a href="{{ route('lab_muestras_index') }}" class="btn btn-sm btn-outline-light ml-2">
                                        <i class="fas fa-redo"></i> Limpiar filtros
                                    </a>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                    {{-- Leyenda según rol para el DL --}}
                        @if (Auth::user()->departamento_id == 1)
                            @php
                                $rolesDL = [
                                    1 => 'Admin',
                                    2 => 'Admin Laboratorio',
                                    3 => 'F.Q. Alimentos',
                                    4 => 'F.Q. Aguas',
                                    5 => 'Ensayo Biológico',
                                    6 => 'Cromatografía',
                                    7 => 'Microbiología',
                                    8 => 'Calidad',
                                ];
                            @endphp
                            <div class="alert alert-secondary mt-3">
                                <strong>Perfil:</strong> {{ $rolesDL[Auth::user()->role_id] ?? 'Sin definir' }} - Usted está viendo las muestras asociadas a su perfil técnico.
                            </div>
                        @endif

                        {{-- Filtros aplicados --}}
                        @if (count(request()->all()) > 0)
                            <div class="alert alert-info">
                                <strong>Filtros aplicados:</strong>
                                <ul class="mb-0">
                                    @if(request('factura') === '1')
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle"></i> Mostrando <strong>solo muestras facturadas</strong>.
                                        </div>
                                    @elseif(request('factura') === '0')
                                        <div class="alert alert-danger">
                                            <i class="fas fa-times-circle"></i> Mostrando <strong>solo muestras no facturadas</strong>.
                                        </div>
                                    @endif
                                    @if(request('numero')) <li>Número: <strong>{{ request('numero') }}</strong></li> @endif
                                    @if(request('muestra')) <li>Muestra: <strong>{{ request('muestra') }}</strong></li> @endif
                                    @if(request('identificacion')) <li>Identificación: <strong>{{ request('identificacion') }}</strong></li> @endif
                                    @if(request('lugar_extraccion')) <li>Lugar de extracción: <strong>{{ request('lugar_extraccion') }}</strong></li> @endif
                                    @if(request('lote')) <li>Lote: <strong>{{ request('lote') }}</strong></li> @endif
                                    @if(request('remitente'))
                                        @php
                                            $remitenteObj = \App\Remitente::find(request('remitente'));
                                        @endphp
                                        <li>Remitente:
                                            <strong>{{ $remitenteObj ? $remitenteObj->nombre : 'Desconocido' }}</strong>
                                        </li>
                                    @endif
                                    @if(request('departamento'))
                                        @php
                                            $departamentoObj = \App\Departamento::find(request('departamento'));
                                        @endphp
                                        <li>Departamento:
                                            <strong>{{ $departamentoObj ? $departamentoObj->departamento : 'Desconocido' }}</strong>
                                        </li>
                                    @endif
                                    @if(request('cargada') !== null)
                                        <li>Estado de firma: <strong>{{ request('cargada') == 1 ? 'Para firmar' : 'No firmadas / Salidas' }}</strong></li>
                                    @endif
                                    @if(request('fecha_entrada_inicio') || request('fecha_entrada_final'))
                                        <li>Fecha de entrada:
                                            <strong>
                                                {{ request('fecha_entrada_inicio') ?? '...' }} → {{ request('fecha_entrada_final') ?? '...' }}
                                            </strong>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
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
                        @if (Auth::user()->departamento_id <> 6)
                            <button type="button" class="btn btn-info btn-sm mb-2 ml-3" onclick="modalFacturaWizard()">Generar Factura</button>
                        @endif
                            <form id="formFactura" action="{{ route('lote') }}" method="POST">
                        @csrf
                        <table class="table table-striped align-items-center table-dark">
                            <thead class="thead-light">
                                @php
                                    $facturaEstado = request('factura');

                                    if ($facturaEstado === '1') {
                                        $siguienteEstado = '0';
                                    } elseif ($facturaEstado === '0') {
                                        $siguienteEstado = null;
                                    } else {
                                        $siguienteEstado = '1';
                                    }

                                    $params = request()->except('page', 'factura');
                                    if (!is_null($siguienteEstado)) {
                                        $params['factura'] = $siguienteEstado;
                                    }

                                    $url = route('lab_muestras_index', $params);
                                @endphp
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Número</th>
                                    <th scope="col">Muestra</th>
                                    @if ((Auth::user()->departamento_id == 2) || (Auth::user()->departamento_id == 3))
                                    <th scope="col">Remite</th>
                                    @elseif (Auth::user()->departamento_id == 4)
                                    <th scope="col">Remite</th>
                                    <th scope="col" class="text-center">Dpto</th>
                                    <th scope="col" class="text-center">Área</th>
                                    @elseif (Auth::user()->role_id <> 13)
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
                                    <th scope="col" style="width:10%">
                                        <a href="{{ $url }}" style="color: grey; text-decoration: none;">
                                            Factura
                                            @if($facturaEstado === '1')
                                                <span class="badge badge-success">✔</span>
                                            @elseif($facturaEstado === '0')
                                                <span class="badge badge-danger">✘</span>
                                            @endif
                                        </a>
                                    </th>
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
                                                    <td style="width:1px"><input type="checkbox" class="control-input" id="selected" name="selected[]" value="{{ $muestra->id }}"></td>
                                                    <td style="width:20px"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}">{{ $muestra->numero}}</a></td>
                                                    <td style="width: 130px"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}"><strong>{{ $muestra->matriz->matriz }} /</strong>
                                                        {{ str_limit($muestra->muestra, 20)}}</a>
                                                    </td>
                                                    @if ((Auth::user()->departamento_id == 2) || (Auth::user()->departamento_id == 3))
                                                    <td style="width:20%"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}">{{ str_limit($muestra->remitente->nombre, 20)}}</a></td>
                                                    @elseif (Auth::user()->departamento_id == 4)
                                                    <td style="width:20%"><a class="text-white" href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}">{{ str_limit($muestra->remitente->nombre, 20)}}</a></td>
                                                    <td class="text-center">{{ $muestra->departamento->departamento ?? '-' }}</td>
                                                            <td class="text-center">
                                                                @php
                                                                    $letrasUtilizadas = [];
                                                                @endphp
                                                                @foreach ($muestra->ensayos as $ensayo)
                                                                    @if (!in_array($ensayo->tipo_ensayo, $letrasUtilizadas))
                                                                        @php $letrasUtilizadas[] = $ensayo->tipo_ensayo; @endphp

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
                                                    @if (in_array(Auth::user()->role_id, [1, 2]) || Auth::user()->departamento_id == 5)
                                                        <td style="width:20%">
                                                            @if ($muestra->factura_id)
                                                                <span class="badge badge-pill badge-success">FACTURADA</span>
                                                            @elseif ($muestra->tipo_prestacion == "APS")
                                                                <span class="badge badge-pill badge-info">APS</span>
                                                            @else
                                                                <span class="badge badge-pill badge-danger">NO FACTURADA</span>
                                                            @endif
                                                        </td>
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
                            @if ((Auth::user()->departamento_id == 1) && (Auth::user()->role_id == 1))
                                <input type="checkbox" id="select-all">
                                <label for="select-all" style="color: white;margin-left: 10px;margin-right: 30px;">Seleccionar todos</label>
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
<!-- Modal Wizard para Generar Factura -->
<style>
  .modal-xxl {
    max-width: 98% !important;
    margin: 1rem auto;
  }
  .nav-tabs .nav-link {
    color: #ccc;
    border: none;
    background-color:rgb(41, 78, 114); /* oscuro */
  }

  .nav-tabs .nav-link.active {
    color: #fff !important;
    background-color: #17a2b8 !important;
    font-weight: bold;
    border-bottom: 3px solid #ffffff !important;
}
</style>

<!-- MODAL FACTURA WIZARD (con diseño mejorado y chosen-select) -->
<div class="modal fade" id="modalFacturaWizard" tabindex="-1" role="dialog" aria-labelledby="modalFacturaWizardLabel">
  <div class="modal-dialog modal-xxl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalFacturaWizardLabel">Generar Factura</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- Tabs -->
        <ul class="nav nav-tabs" id="facturaTabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active bg-info text-white font-weight-bold" data-toggle="tab" href="#paso1" role="tab">Paso 1: Muestras</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#paso2" role="tab">Paso 2: Ítems Extra</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#paso3" role="tab">Paso 3: Confirmación</a>
          </li>
        </ul>

        <div class="tab-content mt-3">
          <!-- Paso 1 -->
          <div class="tab-pane fade show active" id="paso1" role="tabpanel">
            <div id="muestrasSeleccionadas"></div>
            <button class="btn btn-info mt-3" onclick="nextPaso(2)">Siguiente</button>
          </div>

          <!-- Paso 2 -->
          <div class="tab-pane fade" id="paso2" role="tabpanel">
            <label class="mt-2">Ítems del nomenclador:</label>
            <select class="form-control chosen-select form-control-sm" id="nomenclador-select" multiple>
              @foreach ($nomencladors as $nomenclador)
                @if ($nomenclador->departamento_id == Auth::user()->departamento_id)
                  <option value="{{ $nomenclador->id }}">{{ $nomenclador->descripcion }}</option>
                @endif
              @endforeach
            </select>

            <div id="tablaNomencladoresExtras" class="mt-3">
              <!-- JS rellena inputs -->
            </div>

            <button class="btn btn-secondary mt-3" onclick="nextPaso(1)">Atrás</button>
            <button class="btn btn-info mt-3" onclick="nextPaso(3)">Siguiente</button>
          </div>

          <!-- Paso 3 -->
          <div class="tab-pane fade" id="paso3" role="tabpanel">
            <div id="resumenFactura"></div>
            <button class="btn btn-secondary" onclick="nextPaso(2)">Atrás</button>
            <button type="button" id="btnEnviarFactura" class="btn btn-primary">Confirmar y generar factura</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
<script>
$(document).ready(function () {

    // Inicializar chosen-select (IMPORTANTE que esté al principio)
    $('.chosen-select').chosen({
        width: "100%",
        placeholder_text_multiple: "Seleccione ítems"
    });

    // Forzar update al abrir modal (por si estaba oculto)
    $('#modalFacturaWizard').on('shown.bs.modal', function () {
        // Primero destruir cualquier instancia previa para evitar duplicaciones
        if ($('#nomenclador-select').data('chosen')) {
            $('#nomenclador-select').chosen('destroy');
        }
        
        // Luego inicializar nuevamente
        $('#nomenclador-select').chosen({
            width: "100%",
            placeholder_text_multiple: "Seleccione ítems"
        });
    });

    // REFRESH PARA IMPRESIONES
    window.refresh = function () {
        setTimeout(() => window.location.reload(), 1000);
    };

    // SELECCIONAR TODOS LOS CHECKBOX
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('input[name="selected[]"]');
    if (selectAll) {
        selectAll.addEventListener('click', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });
    }

    // MODAL EXCEL → Mostrar texto y cerrar luego
    const enviarBtn = document.getElementById("enviarBtn");
    if (enviarBtn) {
        enviarBtn.addEventListener("click", () => {
            document.getElementById("div").style.display = "block";
            document.getElementById("textoEsp").style.display = "block";
            setTimeout(() => $('#agregaranio').modal("hide"), 10000);
        });
    }

    $('#agregaranio').on('hidden.bs.modal', function () {
        $('#textoEsp').hide();
    });

    // ABRIR MODAL FACTURA
    window.modalFacturaWizard = function () {
        mostrarMuestrasSeleccionadas(); 
        $('#modalFacturaWizard').modal('show');
    };

    // MOSTRAR MUESTRAS SELECCIONADAS
    window.mostrarMuestrasSeleccionadas = function () {
        const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
        const contenedor = document.getElementById('muestrasSeleccionadas');
        contenedor.innerHTML = '';

        if (checkboxes.length === 0) {
            contenedor.innerHTML = '<div class="alert alert-warning">No hay muestras seleccionadas.</div>';
            return;
        }

        const tabla = document.createElement('table');
        tabla.classList.add('table', 'table-bordered', 'table-sm', 'table-dark');
        tabla.innerHTML = `
            <thead><tr><th>ID</th><th>Número</th><th>Muestra</th></tr></thead>
            <tbody></tbody>
        `;

        const tbody = tabla.querySelector('tbody');

        checkboxes.forEach(cb => {
            const row = cb.closest('tr');
            const id = cb.value;
            const numero = row.querySelector('td:nth-child(2)')?.innerText.trim() || '—';
            const muestra = row.querySelector('td:nth-child(3)')?.innerText.trim() || '—';

            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${id}</td><td>${numero}</td><td>${muestra}</td>`;
            tbody.appendChild(tr);
        });

        contenedor.appendChild(tabla);
    };

    // CAMBIO DE PASO
    window.nextPaso = function (paso) {
        $('.tab-pane').removeClass('show active');
        $('.nav-link').removeClass('active');
        $('#paso' + paso).addClass('show active');
        $('a[href="#paso' + paso + '"]').addClass('active');
    };

    // SUBMIT FACTURA
    window.enviarFacturaWizard = function () {
        const form = document.querySelector('form[action="{{ route('lote') }}"]');
        if (!form) {
            alert("No se encontró el formulario.");
            return;
        }

        // Borrar antiguos
        form.querySelectorAll('input[name^="nomenclador_cantidades"]').forEach(el => el.remove());
        form.querySelectorAll('input[name="selected_nomencladors[]"]').forEach(el => el.remove());

        let actionInput = form.querySelector('input[name="action"]');
        if (!actionInput) {
            actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            form.appendChild(actionInput);
        }
        actionInput.value = 'generarFactura';

        // Agregar cantidades
        $('#tablaNomencladoresExtras input').each(function () {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = this.name;
            hidden.value = this.value;
            form.appendChild(hidden);
        });

        // Agregar seleccionados
        const selectedNomencladors = $('#nomenclador-select').val() || [];
        selectedNomencladors.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_nomencladors[]';
            input.value = id;
            form.appendChild(input);
        });

        $('#modalFacturaWizard').modal('hide');
        console.log("Enviando formulario con ítems extras...");
        form.submit();
    };

    // Vincular botón final
    const btn = document.getElementById('btnEnviarFactura');
    if (btn) {
        btn.addEventListener('click', window.enviarFacturaWizard);
    }

    // Cuando cambian ítems, mostrar inputs de cantidad
    $('#nomenclador-select').on('change', function () {
        const seleccionados = $(this).val();
        const contenedor = $('#tablaNomencladoresExtras');
        contenedor.empty();

        if (seleccionados && seleccionados.length > 0) {
            seleccionados.forEach(id => {
                const nombre = $("#nomenclador-select option[value='" + id + "']").text();
                contenedor.append(`
                    <div class="form-group">
                        <label>${nombre}</label>
                        <input type="number" name="nomenclador_cantidades[${id}]" class="form-control" min="1" value="1">
                    </div>
                `);
            });
        }
    });
});
</script>
@endpush

@endsection
