@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Fatigue Sciense</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Personal en FS</h6>
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
                                <th>Asistió</th>
                                <th>Sinc. FS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($responseUsers as $asis)
                                @if (isset($asis->exist_fs))
                                    <tr>
                                        <td>{{$asis->id_fs}}</td>
                                        <td>{{$asis->name}}</td>
                                        <td>{{$asis->identifier}}</td>
                                        <td>{{$asis->email}}</td>
                                        <td class="text-center">
                                            @if (isset($asis->exist_fs))
                                                @if ($asis->exist_fs->exist_fs == 1)
                                                    Sí
                                                @else
                                                    No
                                                @endif                                            
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (isset($asis->exist_fs))
                                                @if ($asis->exist_fs->sync == 1)
                                                    <img src="{{asset('img/checked-32.png')}}" alt="">
                                                @else
                                                    No
                                                @endif                                            
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection