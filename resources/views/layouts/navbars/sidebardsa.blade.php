<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <div class="alert alert-info" role="alert">
            <strong><p align="center">DSA</p></strong>
        </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_muestras_index') }}">
                        <i class="fas fa-info-circle text-primary"></i> {{ __('Muestras') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dsa_notas_index') }}">
                        <i class="fas fa-file-alt text-blue"></i> {{ __('Notas') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pedido_index') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Pedidos') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dsaexpedientes_index') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Expedientes') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dsa_facturas_index') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Facturación') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('facturas_index') }}">
                        <i class="fas fa-file-invoice-dollar text-blue"></i> {{ __('Facturas') }}
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('lab_ensayos_index') }}">
                    <i class="fas fa-flask text-blue"></i> {{ __('Ensayos') }}
                    </a>
                </li>
                <a class="dropdown-item" href="{{ route('remitentes_index') }}">{{ __('Remitentes') }}</a>
            </ul>
    </div>
</nav>