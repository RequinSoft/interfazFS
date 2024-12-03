@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Hikvision</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Asistencia en Hikvision</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id FS</th>
                                <th>Nombre</th>
                                <th>RFC</th>
                                <th>Email</th>
                                <th>Día</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($responseUsers as $asis)
                                <tr>
                                    <td>{{$asis['id']}}</td>
                                    <td>{{$asis['attributes']['first_name'].' '.$asis['attributes']['last_name']}}</td>
                                    <td>{{$asis['attributes']['identifier']}}</td>
                                    <td>{{$asis['attributes']['email']}}</td>
                                    <td></td>
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