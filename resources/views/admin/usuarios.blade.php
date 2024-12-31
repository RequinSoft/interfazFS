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
                <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Día</th>
                            </tr>
                        </thead>
                        @php
                            $n=1;
                        @endphp
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{$n}}</td>
                                    <td>{{$usuario->user}}</td>
                                    <td>{{$usuario->name}}</td>
                                    <td>{{$usuario->rol}}</td>
                                    <td>{{$usuario->email}}</td>
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