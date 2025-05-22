<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span></span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
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
                <li>
                    <a class="nav-link" href="{{ route('lab_ensayos_index') }}">
                    <i class="fas fa-flask text-blue"></i> {{ __('Ensayos') }}
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
                    <a class="nav-link" href="{{ route('facturas_index') }}">
                        <i class="fas fa-file-invoice-dollar text-blue"></i> {{ __('Facturas') }}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notas-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-alt text-blue"></i> {{ __('Notas') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="notas-dropdown">
                        <a class="dropdown-item" href="{{ route('dsa_notas_index') }}">{{ __('Notas DSA') }}</a>
                        <a class="dropdown-item" href="{{ route('dsb_notas_index') }}">{{ __('Notas DSB') }}</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="remitosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-invoice text-blue"></i> {{ __('Remitos') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="remitosDropdown">
                        <a class="dropdown-item" href="{{ route('dsb_remitos_index') }}"> {{ __('Remitos DSB') }} </a>
                        <a class="dropdown-item" href="{{ route('db_remitos_index') }}"> {{ __('Remitos Broma') }} </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="remitosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-invoice text-blue"></i> {{ __('Admin') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="remitosDropdown">
                        <a class="nav-link" href="{{ route('user.index') }}">
                            <i class="ni ni-circle-08 text-primary"></i> {{ __('Usuarios') }}
                        </a>
                        <a class="nav-link" href="{{ route('remitentes_index') }}">
                        <i class="far fa-address-book text-blue"></i> {{ __('Remitentes') }}
                        </a>
                        <a class="nav-link" href="{{ route('proveedores_index') }}">
                        <i class="fas fa-users-cog text-blue"></i> {{ __('Proveedores') }}
                        </a>
                    </div>
                </li>
                @if (Auth::user()->id == 2 || Auth::user()->id == 3)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('anuario_consulta') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Anuario') }}
                    </a>
                </li>
                @endif
                @else
                @endif
            </ul>
        </div>
    </div>
</nav>
