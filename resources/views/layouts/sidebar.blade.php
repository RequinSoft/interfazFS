
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('index')}}">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">{{config('app.name')}}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('index')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-user"></i>
            <span>Datos</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('assistanceHik')}}">Asistencia</a>
                
                @if ($user->rol == 'admin' || $user->rol == 'medicos')
                    <a class="collapse-item" href="{{route('assistanceFS')}}">FS Personas</a>
                    <a class="collapse-item" href="{{route('locations')}}">FS Locations</a>
                @endif
                
                @if ($user->rol == 'admin' || $user->rol == 'COM')
                    <a class="collapse-item" href="{{route('cuadrilleros')}}">Cuadrillas</a>
                @endif
            </div>
        </div>
    </li>

    @if ($user->rol == 'admin')
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConf"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-user"></i>
            <span>Configuración</span>
        </a>
        <div id="collapseConf" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('fsdata')}}">FS Data</a>
                <a class="collapse-item" href="{{route('ldap')}}">LDAP</a>
                <a class="collapse-item" href="{{route('users')}}">Usuarios</a>
            </div>
        </div>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDocumentation"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-user"></i>
            <span>Documentacion</span>
        </a>
        <div id="collapseDocumentation" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" target='_blank' href="{{asset('documentos/reporte1.pdf')}}">Reporte 1</a>
                <a class="collapse-item" target='_blank' href="{{asset('documentos/Locations.pdf')}}">Locations</a>

            </div>
        </div>


    </li>
    @endif



</ul>
<!-- End of Sidebar -->