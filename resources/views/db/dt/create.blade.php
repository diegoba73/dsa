@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="header pb-1 pt-5 pt-md-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Crear Nuevo DT</h6>
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
                    <form method="post" action="{{ route('dt_store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nombre">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control form-control-alternative" placeholder="Nombre" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="dni">DNI</label>
                                        <input type="text" name="dni" id="dni" class="form-control form-control-alternative" placeholder="DNI" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="titulo">Título</label>
                                        <input type="text" name="titulo" id="titulo" class="form-control form-control-alternative" placeholder="Título" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="domicilio">Domicilio</label>
                                        <input type="text" name="domicilio" id="domicilio" class="form-control form-control-alternative" placeholder="Domicilio" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="ciudad">Ciudad</label>
                                        <input type="text" name="ciudad" id="ciudad" class="form-control form-control-alternative" placeholder="Ciudad" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="telefono">Teléfono</label>
                                        <input type="text" name="telefono" id="telefono" class="form-control form-control-alternative" placeholder="Teléfono" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control form-control-alternative" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="universidad">Universidad</label>
                                        <input type="text" name="universidad" id="universidad" class="form-control form-control-alternative" placeholder="Universidad" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="matricula">Matrícula</label>
                                        <input type="text" name="matricula" id="matricula" class="form-control form-control-alternative" placeholder="Matrícula" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="dni_file">DNI (PDF)</label>
                                        <input type="file" name="dni_file" id="dni_file" class="form-control form-control-alternative" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="titulo_file">Título (PDF)</label>
                                        <input type="file" name="titulo_file" id="titulo_file" class="form-control form-control-alternative" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="cv_file">CV (PDF)</label>
                                        <input type="file" name="cv_file" id="cv_file" class="form-control form-control-alternative" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="cert_domicilio_file">Certificado de Domicilio (PDF)</label>
                                        <input type="file" name="cert_domicilio_file" id="cert_domicilio_file" class="form-control form-control-alternative" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="antecedentes_file">Antecedentes (PDF)</label>
                                        <input type="file" name="antecedentes_file" id="antecedentes_file" class="form-control form-control-alternative" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="arancel_file">Arancel (PDF)</label>
                                        <input type="file" name="arancel_file" id="arancel_file" class="form-control form-control-alternative" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="foto_file">FOTO (JPG)</label>
                                        <input type="file" name="foto_file" id="foto_file" class="form-control form-control-alternative" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.footers.auth')
</div>
@endsection
