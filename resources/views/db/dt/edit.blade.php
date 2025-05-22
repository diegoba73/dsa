@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="header pb-1 pt-5 pt-md-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Editar DT</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-2">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Datos del DT</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('db_dt_update', $dt->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nombre">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control form-control-alternative" placeholder="Nombre" value="{{ $dt->nombre }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="dni">DNI</label>
                                        <input type="text" name="dni" id="dni" class="form-control form-control-alternative" placeholder="DNI" value="{{ $dt->dni }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="titulo">Título</label>
                                        <input type="text" name="titulo" id="titulo" class="form-control form-control-alternative" placeholder="Título" value="{{ $dt->titulo }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="domicilio">Domicilio</label>
                                        <input type="text" name="domicilio" id="domicilio" class="form-control form-control-alternative" placeholder="Domicilio" value="{{ $dt->domicilio }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="ciudad">Ciudad</label>
                                        <input type="text" name="ciudad" id="ciudad" class="form-control form-control-alternative" placeholder="Ciudad" value="{{ $dt->ciudad }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="telefono">Teléfono</label>
                                        <input type="text" name="telefono" id="telefono" class="form-control form-control-alternative" placeholder="Teléfono" value="{{ $dt->telefono }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control form-control-alternative" placeholder="Email" value="{{ $dt->email }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="universidad">Universidad</label>
                                        <input type="text" name="universidad" id="universidad" class="form-control form-control-alternative" placeholder="Universidad" value="{{ $dt->universidad }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="matricula">Matrícula</label>
                                        <input type="text" name="matricula" id="matricula" class="form-control form-control-alternative" placeholder="Matrícula" value="{{ $dt->matricula }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="dni_file">DNI (PDF)</label>
                                        <input type="file" name="dni_file" id="dni_file" class="form-control form-control-alternative">
                                        @if($dt->ruta_dni)
                                            <small>Archivo actual: <a href="{{ route('verDNI', $dt->id) }}" target="_blank">Ver DNI</a></small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="titulo_file">Título (PDF)</label>
                                        <input type="file" name="titulo_file" id="titulo_file" class="form-control form-control-alternative">
                                        @if($dt->ruta_titulo)
                                            <small>Archivo actual: <a href="{{ route('verTITULO', $dt->id) }}" target="_blank">Ver Título</a></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="cv_file">CV (PDF)</label>
                                        <input type="file" name="cv_file" id="cv_file" class="form-control form-control-alternative">
                                        @if($dt->ruta_cv)
                                            <small>Archivo actual: <a href="{{ route('verCV', $dt->id) }}" target="_blank">Ver CV</a></small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="cert_domicilio_file">Certificado de Domicilio (PDF)</label>
                                        <input type="file" name="cert_domicilio_file" id="cert_domicilio_file" class="form-control form-control-alternative">
                                        @if($dt->ruta_cert_domicilio)
                                            <small>Archivo actual: <a href="{{ route('verCERT', $dt->id) }}" target="_blank">Ver Certificado de Domicilio</a></small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="antecedentes_file">Antecedentes (PDF)</label>
                                        <input type="file" name="antecedentes_file" id="antecedentes_file" class="form-control form-control-alternative">
                                        @if($dt->ruta_antecedentes)
                                            <small>Archivo actual: <a href="{{ route('verANTECEDENTE', $dt->id) }}" target="_blank">Ver Antecedentes</a></small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="arancel_file">Arancel (PDF)</label>
                                        <input type="file" name="arancel_file" id="arancel_file" class="form-control form-control-alternative">
                                        @if($dt->ruta_arancel)
                                            <small>Archivo actual: <a href="{{ route('verARANCEL', $dt->id) }}" target="_blank">Ver Arancel</a></small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="foto_file">FOTO</label>
                                        <input type="file" name="foto_file" id="foto_file" class="form-control form-control-alternative">
                                        @if($dt->ruta_foto)
                                            <small>Archivo actual: <a href="{{ route('verFOTO', $dt->id) }}" target="_blank">Ver Foto</a></small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dbredbs" class="form-control-label" style="display: block;">Vincular Establecimientos (REDB):</label>
                                        <select class="chosen-select" name="dbredbs[]" id="dbredbs" multiple style="width: 100%;">
                                            @foreach($redbs as $redb)
                                                <option value="{{ $redb->id }}" {{ $redb->dbdt_id == $dt->id ? 'selected' : '' }}>
                                                    {{ $redb->numero }} - {{ $redb->establecimiento }} - {{ $redb->domicilio }}
                                                </option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-default btn-close" href="{{ URL::previous() }}">Cancelar</a>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.footers.auth')
</div>
@endsection