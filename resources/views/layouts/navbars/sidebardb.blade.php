<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <div class="alert alert-info" role="alert">
        <a class="navbar-brand pt-0">
            <img src="{{ asset('argon') }}/img/brand/logo_dsa.png" class="navbar-brand-img" alt="DSA">
        </a>
            <strong><p align="center">Departamento Provincial de Bromatología</p></strong>
        </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_muestras_index') }}">
                        <i class="fas fa-info-circle text-primary"></i> {{ __('Muestras') }}
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
                    <a class="nav-link" href="{{ route('db_remitos_index') }}">
                        <i class="fas fa-file-invoice text-blue"></i> {{ __('Remitos') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pedido_index') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Pedidos') }}
                    </a>
                </li>
                @if (Auth::user()->role_id == 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('remitentes_index') }}">
                        <i class="far fa-address-book text-blue"></i> {{ __('Remitentes') }}
                    </a>
                </li>
                @else
                @endif
                <ul class="navbar-nav">
            </ul>
        </div>
    </div>
</nav>