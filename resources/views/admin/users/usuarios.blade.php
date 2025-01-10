@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Usuarios</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
                <div class="text-right">
                    <a href="{{ route('addUsers') }}" class="btn btn-sm btn-primary" title="Añadir"><i class="text-500 fas fa-user-plus"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">N°</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Autenticación</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td class="text-center">{{ $contador }}</td>
                                    <td>{{$usuario->user}}</td>
                                    <td>{{$usuario->name}}</td>
                                    <td class="text-center">{{$usuario->rol == 'admin' ? 'Administrador':'Usuario'}}</td>
                                    <td class="text-center">{{$usuario->authen == 1 ? 'Local':'LDAP'}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td class="text-center">
                                        @if ($usuario->user != 'admin')
                                            @if ($usuario->active == 1)
                                                @if ($usuario->authen == 1)
                                                    <a href="{{ route('passwords', $usuario->id) }}" class="btn btn-sm" title="Contraseña"><i class="text-500 fas fa-key"></i></a>
                                                    &nbsp; 
                                                @endif
                                                <a href="{{ route('editUsers', $usuario->id) }}" class="btn btn-sm" title="Editar"><i class="text-500 fas fa-edit"></i></a>
                                                &nbsp; 
                                                <a href="{{ route('deleteUsers', $usuario->id) }}" class="btn btn-sm" title="Desactivar"><i class="text-500 fas fa-trash-alt"></i></a>
                                            @else
                                                <a href="{{ route('activateUsers', $usuario->id) }}" class="btn btn-sm btn-danger" title="Activar"><i class="text-500 fas fa-user"></i></a>
                                            @endif
                                        @else
                                            <a href="{{ route('passwords', $usuario->id) }}" class="btn btn-sm" title="Contraseña"><i class="text-500 fas fa-key"></i></a>                                                    
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $contador++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('scripts')

    @if (session('msg_pass'))
    <script>
        Swal.fire({
            title: "Contraseña ",
            text: "{{ session('msg_pass') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

    @if (session('msg_addUser'))
    <script>
        Swal.fire({
            title: "Usuario ",
            text: "{{ session('msg_addUser') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

    @if (session('msg_deactive'))
    <script>
        Swal.fire({
            title: "Usuario ",
            text: "{{ session('msg_deactive') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

    @if (session('msg_active'))
    <script>
        Swal.fire({
            title: "Usuario ",
            text: "{{ session('msg_active') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

@endsection