@extends('layouts.template')

@section('title', 'LDAP')

@section('content')

<div class="container">

    <div class="card o-hidden border-2 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Datos</h1>
                        </div>
                        <form class="user" action="{{route('updateLdap')}}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="servers"
                                        value="{{isset($ldap->servers) ? $ldap->servers : ''}}"
                                        placeholder="Servidor">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" name="port"
                                        value="{{isset($ldap->port) ? $ldap->port : ''}}"
                                        placeholder="Puerto">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="user"
                                        value="{{isset($ldap->user) ? $ldap->user : ''}}"
                                        placeholder="Usuario">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" name="password"
                                        value="{{isset($ldap->password) ? $ldap->password : ''}}"
                                        placeholder="Contraseña">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Guardar
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