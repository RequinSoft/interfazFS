@extends('layouts.template')

@section('title', 'FS Data')

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
                        <form class="user" action="{{route('fsupdate')}}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" name="username"
                                        value="{{isset($fsdata->username) ? $fsdata->username : ''}}"
                                        placeholder="Email">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" name="password"
                                        value="{{isset($fsdata->password) ? $fsdata->password : ''}}"
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