@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'lab.muestras.index', 'title' => __('Sistema DPSA')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
  @include('layouts.menu')
                <div class="content">
                    @if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
                    <div class="container-fluid">
                        <div class="row">
                            @if (Auth::user()->departamento_id == 1)
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-warning card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">content_copy</i>
                                        </div>
                                        <p class="card-category">Laboratorio</p>
                                        <h3 class="card-title">{{$dl->count()}}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">today</i>Pendientes
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-success card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">content_copy</i>
                                        </div>
                                        <p class="card-category">Bromatología</p>
                                        <h3 class="card-title">{{$db->count()}}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">today</i>Pendientes
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-danger card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">content_copy</i>
                                        </div>
                                        <p class="card-category">D.S.O.</p>
                                        <h3 class="card-title">{{$dso->count()}}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">today</i>Pendientes
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-info card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">content_copy</i>
                                        </div>
                                        <p class="card-category">D.S.B.</p>
                                        <h3 class="card-title">{{$dsb->count()}}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">today</i>Pendientes
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif (Auth::user()->departamento_id == 2)
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-success card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">content_copy</i>
                                        </div>
                                        <p class="card-category">Bromatología</p>
                                        <h3 class="card-title">{{count($db)}}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">today</i>Pendientes
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif (Auth::user()->departamento_id == 3)
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-info card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">content_copy</i>
                                        </div>
                                        <p class="card-category">D.S.B.</p>
                                        <h3 class="card-title">{{count($dsb)}}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">today</i>Pendientes
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif (Auth::user()->departamento_id == 4)
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-danger card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">content_copy</i>
                                        </div>
                                        <p class="card-category">D.S.O.</p>
                                        <h3 class="card-title">{{count($dso)}}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">today</i>Pendientes
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-18">
                            <div class="card">
                                <div class="card-header card-header-tabs card-header-primary d-flex">
                                    <h4 class="card-title">Muestras ingresadas</h4>
                                    <a href="{{ route('lab_muestras_create') }}" class="btn btn-default btn-sm ml-auto">Nuevo</a>
                                    <a href="{{ route('enviar_mail') }}" class="btn btn-default btn-sm ml-auto">Enviar Mail</a>
                                </div>
                                <div class="card-header">
                                
                                    <h4>Busqueda de muestras</h4>
                                    {{ Form::open(['route' => 'lab_muestras_index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="container-fluid">
                                    <div class="row">
                                    
                                            <div class="form-group">
                                                <div class="col-md-1">
                                                    {{ Form::text('numero', null, ['class' => 'form-control', 'placeholder' => 'Número']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                {!!Form::select('tipo_muestra',[null=>'Seleccionar Tipo de Muestra'] +  array(
                                                                'Alimentos' => array('Alimento Carneo y Afin' => 'Alimento Carneo y Afin','Alimento Graso' => 'Alimento Graso','Alimento Lacteo' => 'Alimento Lacteo','Alimento Farinaceo' => 'Alimento Farinaceo','Alimento Azucarado' => 'Alimento Azucarado','Alimento Vegetal' => 'Alimento Vegetal','Bebida Hidrica' => 'Bebida Hidrica','Bebida Fermentada' => 'Bebida Fermentada','Bebida Espirituosa' => 'Bebida Espirituosa','Producto Estimulante' => 'Producto Estimulante','Correctivo y Coadjubante' => 'Correctivo y Coadjubante','Alimento de Regimen','Aditivo Alimentario' => 'Aditivo Alimentario'),
                                                                'Aguas' => array('Agua de Red' => 'Agua de Red','Hielo' => 'Hielo','Agua Tratada' => 'Agua Tratada', 'Agua Superficial' => 'Agua Superficial','Agua Subterranea' => 'Agua Subterranea'),
                                                                'Efluentes' => array('Efluente Tratado' => 'Efluente Tratado','Efluente Sin Tratar' => 'Efluente Sin Tratar'),
                                                                'Ambientales' => array('Hisopo' => 'Hisopo','Gasa' => 'Gasa','Placas' => 'Placas','Control Ambiental' => 'Control Ambiental'),
                                                                'Plancton' => array('Fitoplancton' => 'Fitoplancton','Zooplancton' => 'Zooplancton'),
                                                                'Otro' => array('Tejido Orgánico' => 'Tejido Orgánico','Cebo' => 'Cebo','Líquido' => 'Líquido','Extracto vegetal' => 'Extracto vegetal','Polvo Sedimentable' => 'Polvo Sedimentable','Domisanitario' => 'Domisanitario','Productos Desinfectantes' => 'Productos Desinfectantes','Natural' => 'Natural','Preparado' => 'Preparado','Sangre' => 'Sangre','Contenido Estomacal' => 'Contenido Estomacal','No especifica' => 'No especifica'),), null, ['class' => 'chosen-select'])!!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    {{ Form::text('muestra', null, ['class' => 'form-control', 'placeholder' => 'Muestra']) }}
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="col-md-7" text-align="right">
                                                    <label class="bmd-label-floating">Pendientes: {{ Form::checkbox('cargada', $cargada, null, ['class' => 'form-control']) }}</label>
                                                    
                                                </div>
                                            </div>
                                   
                                    <div class="form-group">
                                                <div class="col-md-2">
                                                    {{ Form::select('departamento', $departamento, null, ['class' => 'chosen-select']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    {{ Form::select('remitente', $remitente, null, ['class' => 'chosen-select']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                                    <i class="material-icons">search</i>
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-fab btn-fab-mini btn-round" href="{{ route('lab_muestras_index') }}">
                                                    <i class="material-icons">refresh</i>
                                                </button>
                                            </div>
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
                                                    <th>Muestra</th>
                                                    <th>Dpto.</th>
                                                    <th>Remite</th>
                                                    <th>Ingreso</th>
                                                    <th>Salida</th>
                                                    
                                                </strong>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($muestras as $muestra)
                                                <tr>
                                                    <td class="text-center">{{ $muestra->numero}}</td>
                                                    <td><strong>{{ $muestra->matriz}} /
                                                       {{ $muestra->tipo_muestra}} /</strong>
                                                        {{ $muestra->muestra}}
                                                    </td>
                                                    <td>
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
                                                    <td>{{ $muestra->remitente->nombre}}</td>
                                                    <td>{{ date('d-m-Y', strtotime($muestra->fecha_entrada)) }}</td>
                                                    @if (strtotime($muestra->fecha_salida) > 0)
                                                    <td>{{ date('d-m-Y', strtotime($muestra->fecha_salida)) }}</td>
                                                    @else
                                                    <td><span class="badge badge-pill badge-danger">SIN SALIDA</span></td>
                                                    @endif
                                                    <td class="td-actions text-center">
                                                        <a href="{{ url('/lab/muestras/'.$muestra->id.'/edit')}}" title="Editar" rel="tooltip" class="btn btn-primary btn-round">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                        @if (Auth::user()->departamento_id == 1)
                                                            @if ($muestra->aceptada === null)
                                                            <button onclick="location.href='{{ route('aceptar_muestra', $muestra->id) }}', md.showAceptada('top','right')" title="Aceptar" type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                <i class="material-icons">done</i>
                                                            </button>
                                                            <button onclick="location.href='{{ route('lab_muestras_rechazo', $muestra->id) }}'" title="Rechazar" type="button" rel="tooltip" class="btn btn-primary btn-round">
                                                                <i class="material-icons">clear</i>
                                                            </button>
                                                            @else
                                                            <i></i>
                                                            @endif
                                                            @if ($muestra->aceptada == 1)
                                                            <a href="{{ url('/lab/muestras/'.$muestra->id.'/show')}}" target="_blank" title="HT" rel="tooltip" class="btn btn-primary btn-round">
                                                                <i class="material-icons">visibility</i>
                                                            </a>
                                                            <button onclick="location.href='{{ route('lab_muestras_rechazo', $muestra->id) }}'" title="Rechazar" type="button" rel="tooltip" class="btn btn-primary btn-round">
                                                                <i class="material-icons">clear</i>
                                                            </button>
                                                            <button onclick="location.href='{{ route('lab_muestras_resultado', $muestra->id) }}'" title="Resultados" type="button" rel="tooltip" class="btn btn-primary btn-round">
                                                                <i class="material-icons">list</i>
                                                            </button>
                                                            @else
                                                            <i></i>
                                                            @endif
                                                            @if ($muestra->aceptada === 0)
                                                            <a href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_rechazo')}}" onclick="refresh()" target="_blank" title="Imprimir Rechazo" rel="tooltip" class="btn btn-primary btn-round">
                                                                <i class="material-icons">print</i>
                                                            </a>
                                                            <button onclick="location.href='{{ route('aceptar_muestra', $muestra->id) }}', md.showAceptada('top','right')" title="Aceptar" type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                <i class="material-icons">done</i>
                                                            </button>
                                                            @else
                                                            <i></i>
                                                            @endif 
                                                            @if ($muestra->cargada == 1)
                                                            <a href="{{ url('/lab/muestras/'.$muestra->id.'/imprimir_resultado')}}" onclick="refresh()" target="_blank" title="Imprimir Resultado" rel="tooltip" class="btn btn-primary btn-round">
                                                            <i class="material-icons">print</i>
                                                            </a>
                                                            @else
                                                            <i></i>
                                                            @endif 
                                                        @endif                                                    
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                                {{ $muestras->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        </div>
<script>
function refresh() {
setTimeout(function(){
   window.location.reload();
}, 1000);
}
</script>

@endsection
