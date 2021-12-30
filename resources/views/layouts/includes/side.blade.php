<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="img/icon.png" alt="FOVIPOL" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">FOVIPOL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block"> {{ Auth::user()->full_name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the -->
                <li class="nav-item menu-open">
                    <a href="{{ route('home') }}" class="nav-link @if(request()->routeIs('home')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>


                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('view.atenciones') }}" class="nav-link @if(request()->routeIs('view.atenciones')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Atenciones</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @if(auth()->check() && auth()->user()->hasRoles(['utic']))

                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Configuraciones
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">6</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('view.modulo') }}" class="nav-link @if(request()->routeIs('view.modulo')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Módulos de impresión</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view.tickets') }}" class="nav-link @if(request()->routeIs('view.tickets')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ticketeras</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view.oficinas') }}" class="nav-link @if(request()->routeIs('view.oficinas')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Oficinas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view.posiciones') }}" class="nav-link @if(request()->routeIs('view.posiciones')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Posiciones</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view.query-type-customer') }}" class="nav-link @if(request()->routeIs('view.query-type-customer')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tipo de consultas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view.videos') }}" class="nav-link @if(request()->routeIs('view.videos')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Videos</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Reportes
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('view.report-queuelist') }}" class="nav-link @if(request()->routeIs('view.report-queuelist')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Lista de atenciones</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Graficos</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-check"></i>
                            <p>
                                Accesos
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ">
                                <a href="{{ route('view.role') }}" class="nav-link @if(request()->routeIs('view.role')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view.user') }}" class="nav-link @if(request()->routeIs('view.user')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Usuarios</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">OPERACIONES</li>
                    <li class="nav-item">
                        <a href="{{ route('view.atenciones') }}" class="nav-link @if(request()->routeIs('view.atenciones')) active @endif">
                            <i class="nav-icon fas fa-ellipsis-h"></i>
                            <p>Atenciones</p>
                        </a>
                    </li>

                    <li class="nav-header">DEMO FOVIPOL</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-circle nav-icon"></i>
                            <p>Versión 1</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
