@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'principal', 'title' => __('Sistema DPSA')])

@section('content')
@csrf
<div class="header bg-gradient-primary pb-6 pt-5">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">

          {{-- Mensaje de sesión --}}
          @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Éxito:</strong> {{ session('status') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          {{-- Tarjeta de bienvenida --}}
          <div class="card shadow border-0 animate__animated animate__fadeIn">
            <div class="card-body text-center bg-gradient-default text-white rounded">
              <div class="mb-3">
                <i class="fas fa-dna fa-3x mb-3 text-white"></i>
              </div>
              <h1 class="display-1" style="color: #87CEEB;">Bienvenido/a {{ Auth::user()->name ?? '' }}</h1>
              <p class="lead mt-2">Sistema de Gestión de la <strong>Dirección Provincial de Salud Ambiental</strong></p>
              @include('partials.versiones')
              @include('layouts.footers.auth')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection