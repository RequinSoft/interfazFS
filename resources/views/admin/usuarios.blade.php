@extends('layouts.template')

@section('title', 'Usuarios')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Usuarios</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">

                <div class="text-right">
                    <a href="{{ route('addUsers') }}" class="btn btn-sm btn-primary" title="Añadir"><i class="text-500 fas fa-plus"></i></a>
                </div>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class='text-center'>N°</th>
                                <th class='text-center'>Usuario</th>
                                <th class='text-center'>Nombre</th>
                                <th class='text-center'>Rol</th>
                                <th class='text-center'>Autenticación</th>
                                <th class='text-center'>Email</th>
                                <th class='text-center'>Acciones</th>
                            </tr>
                        </thead>
                        @php
                            $n=1;
                        @endphp
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td class='text-center'>{{$n}}</td>
                                    <td>{{$usuario->user}}</td>
                                    <td>{{$usuario->name}}</td>
                                    <td class='text-center'>{{$usuario->rol}}</td>
                                    <td class='text-center'>{{$usuario->authen == 1 ? 'Local':'LDAP'}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td class='text-center'>
                                        <a href="{{ route('passwords', $usuario->id) }}" class="btn btn-sm" title="Contraseña"><i class="text-500 fas fa-key"></i></a>
                                        &nbsp; 
                                        <a href="{{ route('editUsers', $usuario->id) }}" class="btn btn-sm" title="Editar"><i class="text-500 fas fa-edit"></i></a>
                                        &nbsp; 
                                        @if ($usuario->rol == 'admin')
                                            <a href="{{ route('deleteUsers', $usuario->id) }}" class="btn btn-sm" title="Eliminar"><i class="text-500 fas fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('script')

@endsection