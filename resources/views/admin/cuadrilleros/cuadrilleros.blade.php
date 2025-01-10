@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Cuadrilleros</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
                <div class="text-right">
                    <a href="{{ route('addCuadrilleros') }}" class="btn btn-sm btn-primary" title="Añadir"><i class="text-500 fas fa-user-plus"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">N°</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Lugar</th>
                                <th class="text-center">RFC</th>
                                <th class="text-center">SDN</th>
                                <th class="text-center">SDN</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cuadrilleros as $cuadrillero)
                                <tr>
                                    <td class="text-center">{{ $contador }}</td>
                                    <td>{{$cuadrillero->name}}</td>
                                    <td class="text-center">{{$cuadrillero->work_role}}</td>
                                    <td class="text-center">{{$cuadrillero->work_place}}</td>
                                    <td class="text-center">{{$cuadrillero->RFC}}</td>
                                    <td class="text-center">{{$cuadrillero->sdn}}</td>
                                    <td class="text-center">{{$cuadrillero->asistioCuadrillero}}</td>
                                    <td class="text-center">
                                            @if ($cuadrillero->active == 1)
                                                <a href="{{ route('editCuadrilleros', $cuadrillero->id) }}" class="btn btn-sm" title="Editar"><i class="text-500 fas fa-edit"></i></a>
                                                &nbsp; 
                                                <a href="{{ route('deleteCuadrilleros', $cuadrillero->id) }}" class="btn btn-sm" title="Desactivar"><i class="text-500 fas fa-trash-alt"></i></a>
                                            @else
                                                <a href="{{ route('activateCuadrilleros', $cuadrillero->id) }}" class="btn btn-sm btn-danger" title="Activar"><i class="text-500 fas fa-user"></i></a>
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

    @if (session('msg_addUser'))
    <script>
        Swal.fire({
            title: "Cuadrillero ",
            text: "{{ session('msg_addUser') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

    @if (session('msg_editUser'))
    <script>
        Swal.fire({
            title: "Cuadrillero ",
            text: "{{ session('msg_editUser') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

    @if (session('msg_deactive'))
    <script>
        Swal.fire({
            title: "Cuadrillero ",
            text: "{{ session('msg_deactive') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

    @if (session('msg_active'))
    <script>
        Swal.fire({
            title: "Cuadrillero ",
            text: "{{ session('msg_active') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

@endsection