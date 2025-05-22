<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        @if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 9))
        <div class="alert alert-info" role="alert">
            <strong><p align="center">DPB</p></strong>
        </div>
        @endif
        @if (Auth::user()->role_id == 15)
        <div class="alert alert-info" role="alert">
            <strong><p align="center">PRODUCTOR</p></strong>
        </div>
        @endif
            <!-- Navigation -->
            <ul class="navbar-nav">
                @if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 9))
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
                    <a class="nav-link" href="{{ route('db_me_index') }}">
                        <i class="fas fa-info-circle text-primary"></i> {{ __('Mesa Entrada') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_notas_index') }}">
                        <i class="fas fa-file-alt text-blue"></i> {{ __('Notas') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_exp_index') }}">
                        <i class="fas fa-folder-open text-blue"></i> {{ __('Expedientes') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_archivo_index') }}">
                        <i class="fas fa-folder-open text-blue"></i> {{ __('Archivos') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_remitos_index') }}">
                        <i class="fas fa-file-invoice text-blue"></i> {{ __('Remitos') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pedido_index') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Pedidos') }}
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_empresa_index') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('EMPRESA') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_redb_index') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('REDB') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_rpadb_index') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('RPADB') }}
                    </a>
                </li>
                @if (Auth::user()->role_id <> 15)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_inspeccion_index') }}">
                        <i class="far fa-eye text-blue"></i> {{ __('INSPECCIONES') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_historial_index') }}">
                        <i class="far fa-eye text-blue"></i> {{ __('HISTORIAL') }}
                    </a>
                </li>
                @else
                @endif
                @if (Auth::user()->role_id == 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('remitentes_index') }}">
                        <i class="far fa-address-book text-blue"></i> {{ __('Remitentes') }}
                    </a>
                </li>
                @else
                @endif
                @if (Auth::user()->id == 4)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('anuario_consulta') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Anuario') }}
                    </a>
                </li>
                @endif
                <ul class="navbar-nav">
            </ul>
        </div>
    </div>
</nav>