<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <!-- Brand -->
        <div class="alert alert-info" role="alert">
            <strong><p align="center">Area de Cliente</p></strong>
        </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lab_muestras_index') }}">
                        <i class="fas fa-info-circle text-primary"></i> {{ __('Muestras') }}
                    </a>
                </li>
            </ul>
    </div>
</nav>