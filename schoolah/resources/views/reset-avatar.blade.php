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
        .button-color:active,
        .button-color:hover,
        .button-color:focus,
        .button-color:after,
        .button-color {
            background-color: #27bff2 !important;
            border-color: #27bff2 !important;
        }
        .have-image {
            max-height: 15em;
            height: 15em;
            margin: 0 auto;
            display: block;
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
                        <h4>Please insert your profile photo</h4>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-lg-3 col-lg-6 offset-lg-3">
                    <input type="file" @change="onFileChange" :class="'form-control '+error.class.image" style="padding-bottom: 36px" accept="image/*">
                </div>
            </div>
            <div v-if="addClass.image">
                <img :src="image" :class="'img-responsive mt-1 mb-1 '+addClass.image" >
            </div>
            <div class="form-group row mb-0">
                <div class="offset-lg-3 col-lg-6 offset-lg-3">
                    <button type="submit" class="btn btn-primary w-100 button-color" @click="getPhoto()">My profile photo</button>
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
                error: {
                    class: {
                        image: ""
                    },
                },
                addClass: {
                    image: ""
                },
                image: '',
                imageNotBase64: null
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
                            if(app.user.role != "teacher" && app.user.role != "student") {
                                window.location = "/home"
                            }else {
                                if(app.user.avatar != "img/no-pict") {
                                    window.location = "/home"
                                }
                            }
                        }
                    })
                },
                onFileChange(e) {
                    this.imageNotBase64 = e.target.files[0]
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createImage(files[0]);
                },
                createImage(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.image = e.target.result;
                        this.addClass.image = "have-image"
                    };
                    reader.readAsDataURL(file);
                },
                getPhoto() {
                    if(this.addClass.image == "") {
                        this.error.class.image = "is-invalid"
                    } else {
                        this.error.class.image = ""
                    }

                    if(this.error.class.image == "") {
                        this.sendPhoto()
                    }
                },
                sendPhoto() {
                    let requestData = new FormData()
                    requestData.append('file', app.imageNotBase64)
                    axios.post('/reset-avatar-action', requestData)
                    .then(function (response) {
                        if(response.status == 200) {
                            console.log(response.data)
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