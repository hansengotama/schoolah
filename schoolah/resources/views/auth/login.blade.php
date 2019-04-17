<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/logo-white.jpeg') }}">
    <title>Schoolah</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Font google -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
    <!--  Custom CSS -->
    <style>
        .picture-center {
            margin: 0 auto;
            display: block;
            width: 8em;
        }
        .container-form-login {
            position: absolute;
            top: 25%;
            left: 19%;
            width: 60%;
            padding: 2% 3% 1%;
            z-index: 99;
            background: #f7f7f7;
            min-height: 25em;
        }
        .button-color {
             background-color: #27bff2;
             border-color: #27bff2;
         }
        .button-color:after {
            background-color: #27bff2;
            border-color: #27bff2;
        }
        .button-color:focus {
            background-color: #27bff2;
            border-color: #27bff2;
        }
        .button-color:active {
            background-color: #27bff2;
            border-color: #27bff2;
        }
        .button-color:hover {
            background-color: #27bff2;
            border-color: #27bff2;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="row justify-content-center">
                <div class="container-form-login">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <img src="{{ url('img/logo-white.jpeg') }}" alt="" class="picture-center">
                        </div>
                        <div class="form-group row" >
                            <div class="offset-lg-3 col-lg-6 offset-lg-3">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Insert email" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-lg-3 col-lg-6 offset-lg-3">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Insert password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="offset-lg-3 col-lg-6 offset-lg-3">
                                <button type="submit" class="btn btn-primary w-100 button-color">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div style="position: relative; width: 100%; background-color: rgb(153, 202, 218); min-height: 100vh"></div>
    </div>
</body>
