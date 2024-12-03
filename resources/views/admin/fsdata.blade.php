@extends('layouts.template')

@section('title', 'FS Data')

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
                        <!--
                        <div class="col-lg-4 text-right">
                            <a class="btn btn-primary" href="{{route('getDataFS')}}">Obtener Accesos</a>
                        </div>
                        -->
                    
                    </div>

                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Datos</h1>
                        </div>
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="">Email</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($fsdata->username) ? $fsdata->username : ''}}"
                                        placeholder="Email">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Contraseña</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($fsdata->password) ? $fsdata->password : ''}}"
                                        placeholder="Contraseña">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="">Grand Type</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($fsdata->grand_type) ? $fsdata->grand_type : ''}}"
                                        placeholder="Email">
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="">Creado</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($fsdata->created) ? $fsdata->created : ''}}"
                                        placeholder="Email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="">Access Token</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($fsdata->access_token) ? $fsdata->access_token : ''}}"
                                        placeholder="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="">Token Type</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($fsdata->token_type) ? $fsdata->token_type : ''}}"
                                        placeholder="">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Expira en</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($fsdata->expires_in) ? $fsdata->expires_in : ''}}"
                                        placeholder="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="">Refresh Token</label>
                                    <input disabled type="text" class="form-control form-control-user" 
                                        value="{{isset($fsdata->refresh_token) ? $fsdata->refresh_token : ''}}"
                                        placeholder="">
                                </div>
                            </div>
                            
                            <a href="{{route('fsdata-edit')}}" class="btn btn-primary btn-user btn-block">
                                Editar
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection