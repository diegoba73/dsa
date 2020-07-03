<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <div class="alert alert-info" role="alert">
        <a class="navbar-brand pt-0">
            <img src="{{ asset('argon') }}/img/brand/logo.png" class="navbar-brand-img" alt="DSA">
        </a>
            <strong><p align="center">Departamento Provincial Laboratorio de Salud Ambiental</p></strong>
        </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_muestras_index') }}">
                        <i class="fas fa-info-circle text-primary"></i> {{ __('Muestras') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_notas_index') }}">
                        <i class="fas fa-file-alt text-blue"></i> {{ __('Notas') }}
                    </a>
                </li>
                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3 || Auth::user()->role_id == 4 || Auth::user()->role_id == 5 || Auth::user()->role_id == 6 || Auth::user()->role_id == 7 || Auth::user()->role_id == 8)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_reactivos_index') }}">
                        <i class="fas fa-vial text-blue"></i> {{ __('Reactivos') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_insumos_index') }}">
                        <i class="fas fa-vials text-blue"></i> {{ __('Insumos') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pedido_index') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Pedidos') }}
                    </a>
                </li>
                @endif
                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 7 || Auth::user()->role_id == 8)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_cepario_index') }}">
                        <i class="fas fa-microscope text-blue"></i> {{ __('Cepario') }}
                    </a>
                </li>
                @endif
                @if (Auth::user()->role_id == 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dsb_remitos_index') }}">
                        <i class="fas fa-file-invoice text-blue"></i> {{ __('Remitos DSB') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="ni ni-circle-08 text-primary"></i> {{ __('Usuarios') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_ensayos_index') }}">
                        <i class="fas fa-flask text-blue"></i> {{ __('Ensayos') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('remitentes_index') }}">
                        <i class="far fa-address-book text-blue"></i> {{ __('Remitentes') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('proveedores_index') }}">
                        <i class="fas fa-users-cog text-blue"></i> {{ __('Proveedores') }}
                    </a>
                </li>
                @else
                @endif
            </ul>
            <div class="hide">
            @if (Auth::user()->role_id == 1)
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Documentación</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-book"></i> Manuales
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-medal"></i> Calidad
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-book-open"></i> Registro
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/charts/appointments/line')}}">
                        <i class="fas fa-list-alt"></i> {{ __('Reportes') }}
                    </a>
                </li>
            </ul>
            @else
            @endif
            </div>
    </div>
</nav>