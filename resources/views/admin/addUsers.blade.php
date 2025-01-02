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
                            <h1 class="h4 text-gray-900 mb-4">Usuarios</h1>
                        </div>
                        <form class="user" action="{{route('storageUsers')}}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="user"
                                        value="{{old('user')}}"
                                        placeholder="Usuario">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" name="Nombre"
                                        value="{{old('name')}}"
                                        placeholder="Nombre">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="password"
                                        value="{{old('password')}}"
                                        placeholder="Contraseña">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" name="password1"
                                        value="{{old('password1')}}"
                                        placeholder="Repetir Contraseña">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="email"
                                        value="{{old('email')}}"
                                        placeholder="Email">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                Guardar
                            </button>
                            <button type="submit" class="btn btn-danger">
                                Cancelar
                            </button>
                        </form>
                    </div>

                    <div class="col-12 col-md-12 mb-3">
                        <!-- Link -->
                        <p class="text-body-secondary text mb-5">
                        @foreach ($errors->all() as $error)
                        <label class="form-label"></label>
                        <label class="btn btn-warning" for="option1">
                            <i class="fe fe-alert-triangle"></i> 
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