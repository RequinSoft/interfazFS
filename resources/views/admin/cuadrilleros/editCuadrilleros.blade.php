@extends('layouts.template')

@section('title', 'Usuarios')

@section('content')

<div class="container">

    <div class="card o-hidden border-2 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Editar Cuadrillero</h1>
                        </div>
                        <form class="user" action="{{route('updateCuadrilleros')}}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="name"
                                        value="{{$cuadrillero->name}}"
                                        placeholder="Nombre">

                                    <input type="text" class="form-control form-control-user" name="id"
                                        value="{{$cuadrillero->id}}" hidden>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" name="sdn"
                                        value="{{$cuadrillero->sdn}}"
                                        placeholder="SDN">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="work_role"
                                        value="{{$cuadrillero->work_role}}"
                                        placeholder="Rol">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" name="work_place"
                                        value="{{$cuadrillero->work_place}}"
                                        placeholder="Lugar">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="RFC"
                                        value="{{$cuadrillero->RFC}}"
                                        placeholder="RFC">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                Guardar
                            </button>
                            <a href="{{route('cuadrilleros')}}" class="btn btn-danger">
                                Cancelar
                            </a>
                        </form>
                    </div>

                    <div class="col-12 col-md-12 mb-3">
                        <!-- Link -->
                        <p class="text-body-secondary text mb-5">
                        @foreach ($errors->all() as $error)
                        <label class="form-label"></label>
                        <label class="btn btn-warning" for="option1">
                            <i class="fas fa-exclamation-triangle"></i> 
                            {{$error}}
                        </label>
                        @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection