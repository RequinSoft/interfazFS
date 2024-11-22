<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('app.name') }} </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/juanicipio.ico">
    <link href="../resources/css/style.css" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Interfaz FS</h4>
                                    <form action="{{route('login')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label><strong>Usuario</strong></label>
                                            <input name="user" type="text" class="form-control" value="{{old('user')}}">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Contraseña</strong></label>
                                            <input name="password" type="password" class="form-control">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <div class="form-check ml-2">
                                                    <input class="form-check-input" type="checkbox" id="basic_checkbox_1">
                                                    <label class="form-check-label" for="basic_checkbox_1">Recuerdame</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                @foreach ($errors->all() as $error)
                                                  <div class="form-group">  
                                                    <p class="small text-danger">  
                                                      <i class="bi bi-exclamation-triangle">
                                                          {{$error}}    
                                                      </i>
                                                    </p>
                                                  </div>
                                                @endforeach
                                                <!-- <a href="page-forgot-password.html">Forgot Password?</a> -->
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="../resources//vendor/global/global.min.js"></script>
    <script src="../resources//js/quixnav-init.js"></script>
    <script src="../resources//js/custom.min.js"></script>

</body>

</html>