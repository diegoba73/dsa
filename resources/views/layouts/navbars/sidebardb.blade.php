<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        @if (in_array(Auth::user()->role_id, [1, 9, 16, 17, 18]))
        <div class="alert alert-info" role="alert">
            <strong><p align="center">AUTORIDAD SANITARIA</p></strong>
        </div>
        @endif
        @if (Auth::user()->role_id == 15)
        <div class="alert alert-info" role="alert">
            <strong><p align="center">DPB</p></strong>
            <strong><p align="center">PRODUCTOR</p></strong>
        </div>
        @endif
        <!-- Navigation -->
        <ul class="navbar-nav">
            @if (Auth::user()->role_id == 9 || Auth::user()->role_id == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('lab_muestras_index') }}">
                    <i class="fas fa-vials text-primary"></i> {{ __('MUESTRAS') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('facturas_index') }}">
                    <i class="fas fa-receipt text-blue"></i> {{ __('FACTURAS') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('db_notas_index') }}">
                    <i class="fas fa-sticky-note text-blue"></i> {{ __('NOTAS') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('db_exp_index') }}">
                    <i class="fas fa-file-alt text-blue"></i> {{ __('EXPEDIENTES') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('db_archivo_index') }}">
                    <i class="fas fa-archive text-blue"></i> {{ __('ARCHIVOS') }}
                </a>
            </li>
            <!-- Dropdown FISCALIZACION -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="fiscalizacionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-tasks text-blue"></i> {{ __('FISCALIZACIÓN') }}
                </a>
                <div class="dropdown-menu" aria-labelledby="fiscalizacionDropdown">
                    <a class="dropdown-item" href="{{ route('db_tramites_index') }}">
                        <i class="fas fa-file-signature text-blue"></i> {{ __('TRÁMITES') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('db_redb_index') }}">
                        <i class="fas fa-warehouse text-blue"></i> {{ __('ESTABLECIMIENTOS') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('db_rpadb_index') }}">
                        <i class="fas fa-box-open text-blue"></i> {{ __('PRODUCTOS') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('db_inspeccion_index') }}">
                        <i class="fas fa-search text-blue"></i> {{ __('INSPECCIONES') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('db_baja_index') }}">
                        <i class="fas fa-search text-blue"></i> {{ __('BAJAS') }}
                    </a>
                </div>
            </li>
            @endif

            @if(in_array(Auth::user()->role_id, [1, 9]))
                <!-- Dropdown REMITOS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="remitosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-invoice text-blue"></i> {{ __('REMITOS') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="remitosDropdown">
                        <a class="dropdown-item" href="{{ route('db_remitos_index') }}">{{ __('REMITOS DB') }}</a>
                        @if (Auth::user()->id == 4)
                        <a class="dropdown-item" href="{{ route('dso_remitos_index') }}">{{ __('REMITOS DSO') }}</a>
                        <a class="dropdown-item" href="{{ route('dsb_remitos_index') }}">{{ __('REMITOS DSB') }}</a>
                        @endif
                    </div>
                </li>

                <!-- Dropdown ADMINISTRACION -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cogs text-blue"></i> {{ __('ADMINISTRACION') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="adminDropdown">
                        <a class="dropdown-item" href="{{ route('pedido_index') }}">{{ __('PEDIDOS') }}</a>
                        <a class="dropdown-item" href="{{ route('remitentes_index') }}">{{ __('REMITENTES') }}</a>
                        <a class="dropdown-item" href="{{ route('user.index') }}">{{ __('USUARIOS') }}</a>
                        <a class="dropdown-item" href="{{ route('db_empresa_index') }}">{{ __('EMPRESA') }}</a>
                        <a class="dropdown-item" href="{{ route('db_dt_index') }}">{{ __('DT') }}</a>
                    </div>
                </li>
            @endif

            @if (Auth::user()->role_id == 15)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_tramites_index') }}">
                        <i class="fas fa-folder text-blue"></i> {{ __('VER MIS TRÁMITES') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('facturas_index') }}">
                        <i class="fas fa-file-invoice-dollar text-blue"></i> {{ __('MIS FACTURAS') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_redb_index') }}">
                        <i class="fas fa-warehouse text-blue"></i> {{ __('ESTABLECIMIENTOS') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('db_rpadb_index') }}">
                        <i class="fas fa-box-open text-blue"></i> {{ __('PRODUCTOS') }}
                    </a>
                </li>
                @endif
            @if (in_array(Auth::user()->role_id, [16, 17, 18]))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_muestras_index') }}">
                        <i class="fas fa-info-circle text-primary"></i> {{ __('MUESTRAS') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('facturas_index') }}">
                        <i class="fas fa-file-invoice-dollar text-blue"></i> {{ __('FACTURAS') }}
                    </a>
                </li>
                <!-- Dropdown FISCALIZACION -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="fiscalizacionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-clipboard-check text-blue"></i> {{ __('FISCALIZACIÓN') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="fiscalizacionDropdown">
                        <a class="dropdown-item" href="{{ route('db_empresa_index') }}">
                            <i class="fas fa-building text-blue"></i> {{ __('EMPRESA') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('db_tramites_index') }}">
                            <i class="fas fa-file-alt text-blue"></i> {{ __('TRÁMITES') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('db_redb_index') }}">
                            <i class="fas fa-industry text-blue"></i> {{ __('ESTABLECIMIENTOS') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('db_rpadb_index') }}">
                            <i class="fas fa-boxes text-blue"></i> {{ __('PRODUCTOS') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('db_inspeccion_index') }}">
                            <i class="fas fa-search text-blue"></i> {{ __('INSPECCIONES') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('db_dt_index') }}">
                            <i class="fas fa-user-tie text-blue"></i> {{ __('DT') }}
                        </a>
                    </div>
                </li>
            @endif
            @if (Auth::user()->id == 4)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('anuario_consulta') }}">
                        <i class="fas fa-inbox text-blue"></i> {{ __('Anuario') }}
                    </a>
                </li>
            @endif
        </ul>
        </div>
    </div>
</nav>