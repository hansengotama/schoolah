@extends('layouts.app')

@section('css')
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
        .text-align-left {
            text-align: left !important;
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
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container-form-login">
            <div class="mb-3">
                <img src="{{ url('img/logo-white.jpeg') }}" alt="" class="picture-center">
            </div>
            <div class="form-group row">
                <div class="offset-lg-3 col-lg-6 offset-lg-3">
                    <div>
                        <h3>Hi, @{{ user.name }}</h3>
                        <h4>Please reset your password</h4>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-lg-3 col-lg-6 offset-lg-3">
                    <input id="password" type="password" :class="'form-control '+error.class.newPassword" v-model="newPassword" placeholder="Insert new password" required>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="offset-lg-3 col-lg-6 offset-lg-3">
                    <button type="submit" class="btn btn-primary w-100 button-color text-align-left" @click="validatePassword">Reset Password</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="position: relative; width: 100%; background-color: rgb(153, 202, 218); min-height: 100vh"></div>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                user: {},
                newPassword: "",
                error: {
                    class: {
                        newPassword: ""
                    },
                }
            },
            mounted() {
                this.getUserData()
            },
            methods: {
                required(value) {
                    return (value.length < 1) ? true : false
                },
                popUpError() {
                    swal({
                        heightAuto: true,
                        type: 'error',
                        title: 'Error!',
                    })
                },
                popUpSuccess() {
                    swal({
                        heightAuto: true,
                        type: 'success',
                        title: 'Success!',
                    })
                },
                getUserData() {
                    axios.get('{{ url('get-user-data') }}')
                    .then(function (response) {
                        if(response.status == 200) {
                            app.user = response.data
                        }
                    })
                },
                validatePassword() {
                    if(this.required(this.newPassword)) {
                        this.error.class.newPassword = "is-invalid"
                    }else {
                        this.error.class.newPassword = ""
                    }

                    if(this.error.class.newPassword == "") {
                        this.checkPassword()
                    }
                },
                checkPassword() {
                    axios.post('{{ url('reset-password-action') }}', {
                        "password" : this.newPassword
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.popUpSuccess()
                            window.location = "/home"
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        this.popUpError()
                    })
                }
            }
        })
    </script>
@endsection