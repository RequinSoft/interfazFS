@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">FS</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Locations en FS</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">N°</th>
                                <th>Nombre</th>
                                <th>Id FS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locations as $locations)
                                <tr>
                                    <td class="text-center">{{$locations->id}}</td>
                                    <td>{{$locations->name}}</td>
                                    <td>{{$locations->id_fs}}</td>
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