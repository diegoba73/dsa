@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'principal', 'title' => __('Sistema DPSA')])

@section('content')
@csrf
<div class="header bg-primary pb-8 pt-5 pt-md-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="content">
            <div class="card-body">
              @if (session('status'))
                <div class="alert alert-success" role="alert">
                  {{ session('status') }}
                </div>
              @endif
            </div>
            <div class="card text-white bg-gradient-default mt-1 mb-2 mb-lg-0">
                <div class="card-body">
                <h1 style = "color: white">Bienvenido al Sistema de Gestión  de la Dirección de Salud Ambiental</h1>
                    <h3 style = "color: white"><strong>Frase del día: <i align="center">" {{ $translatedText }} - {{ $author }}"</i></strong></h3>
                </div>            
            </div>

      </div>
    </div>
  </div>
</div>
@endsection
