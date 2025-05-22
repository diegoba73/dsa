<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <!-- Brand -->
        <div class="alert alert-info" role="alert">
            <strong><p align="center">DPSB</p></strong>
        </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_muestras_index') }}">
                        <i class="fas fa-info-circle text-primary"></i> {{ __('Muestras') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('facturas_index') }}">
                        <i class="fas fa-file-invoice-dollar text-blue"></i> {{ __('Facturas') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dsb_notas_index') }}">
                        <i class="fas fa-file-alt text-blue"></i> {{ __('Notas') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dsb_remitos_index') }}">
                        <i class="fas fa-file-invoice text-blue"></i> {{ __('Remitos') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pedido_index') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Pedidos') }}
                    </a>
                </li>
                @if (Auth::user()->id == 28)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('remitentes_index') }}">
                        <i class="far fa-address-book text-blue"></i> {{ __('Remitentes') }}
                    </a>
                </li>
                @endif
                @if (in_array(Auth::user()->id, [6, 28, 30]))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('anuario_consulta') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Anuario') }}
                    </a>
                </li>
                @endif
            </ul>
    </div>
</nav>