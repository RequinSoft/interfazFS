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
                            <h1 class="h4 text-gray-900 mb-4">Editar Usuarios</h1>
                        </div>
                        <form class="user" action="{{route('updateUsers')}}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="user"
                                        value="{{$usuario->user}}"
                                        placeholder="Usuario">

                                    <input type="text" class="form-control form-control-user" name="id"
                                        value="{{$usuario->id}}" hidden>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" name="name"
                                        value="{{$usuario->name}}"
                                        placeholder="Nombre">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select class="form-control rounded-pill" name="rol">
                                        @if ($usuario->rol == 'admin')
                                            <option selected value="admin">Admin</option>
                                            <option value="medicos">Medicos</option>
                                            <option value="COM">COM</option>
                                        @elseif ($usuario->rol == 'medicos')
                                            <option value="admin">Admin</option>
                                            <option selected value="medicos">Medicos</option>   
                                            <option value="COM">COM</option>   
                                        @elseif ($usuario->rol == 'COM')
                                            <option value="admin">Admin</option>
                                            <option value="medicos">Medicos</option>
                                            <option selected value="COM">COM</option>                                       
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select class="form-control rounded-pill" name="authen">
                                        @if ($usuario->authen == 1)
                                            <option selected value="1">Local</option>
                                            <option value="2">LDAP</option>
                                        @else
                                            <option value="1">Local</option>
                                            <option selected value="2">LDAP</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="email"
                                        value="{{$usuario->email}}"
                                        placeholder="Email">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                Guardar
                            </button>
                            <a href="{{route('users')}}" class="btn btn-danger">
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