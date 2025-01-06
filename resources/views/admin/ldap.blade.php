@extends('layouts.template')

@section('title', 'LDAP')

@section('content')

<div class="container">

    <div class="card o-hidden border-2 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row col-lg-12 mt-3">
                        <div class="col-lg-8">
                            @foreach ($errors->all() as $error)
                                <label class="btn btn-warning" for="option1">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{$error}}
                                </label>
                            @endforeach
                        </div>
                    
                    </div>

                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">LDAP</h1>
                        </div>
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="">Server</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($ldap->servers) ? $ldap->servers : ''}}"
                                        placeholder="Servidor">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Puerto</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($ldap->port) ? $ldap->port : ''}}"
                                        placeholder="Puerto">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="">Usuario</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($ldap->user) ? $ldap->user : ''}}"
                                        placeholder="Usuario">
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="">Contraseña</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($ldap->password) ? $ldap->password : ''}}"
                                        placeholder="Contraseña">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="">Dominio</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($ldap->domain) ? $ldap->domain : ''}}"
                                        placeholder="Dominio">
                                </div>
                            </div>
                            
                            <a href="{{route('editLdap')}}" class="btn btn-primary btn-user">
                                Editar
                            </a>
                            
                            <a href="{{route('testLdap')}}" class="btn btn-success btn-user">
                                Probar
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')

    @if (session('failureLDAP'))
    <script>
        Swal.fire({
            icon: "error",
            type: "error",
            title: "LDAP ",
            text: "{{ session('failureLDAP') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

    @if (session('successLDAP'))
    <script>
        Swal.fire({
            icon: "success",
            type: "success",
            title: "LDAP ",
            text: "{{ session('successLDAP') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

    @if (session('updatedLDAP'))
    <script>
        Swal.fire({
            icon: "success",
            type: "success",
            title: "LDAP ",
            text: "{{ session('updatedLDAP') }}",
            confirmButtonText: "Aceptar",
        });
    </script>
    @endif

@endsection