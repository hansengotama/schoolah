@extends('layouts.app-admin')

@section('css')
    <style>
        .margin-10px {
            margin: 10px;
        }

        .about-possition {
            margin:1em auto 0;
            float: none;
            display: table;
        }
        .about-title-size {
            font-weight: 600;
        }
        .about-content-style {
            color: #646464;
            font-size: medium;
            padding: 0 3em;
            margin-top: 1em;
            margin-bottom: 3em;
            text-align: center;
        }
        .btn-feedback,
        .btn-feedback:after,
        .btn-feedback:focus,
        .btn-feedback:active,
        .btn-feedback:hover,
        .btn-feedback:target,
        .btn-feedback:before {
            border: 1px solid white !important;
            width: 100% !important;
            color: #6c757d !important;
            background: #99cada !important;
        }

    </style>
@endsection

@section('content')
<section class="home">
    <div class="header">
        <img src="{{ url('img/HEADER.jpg') }}" alt="" class="img-fluid w-100">
    </div>
    <div class="jumbotron jumbotron-fluid bg-white" id="about">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="white-box box-sizing">
                            <img src="{{ asset('img/assignment.png') }}" class="about-icon-size about-possition" width="20%">
                            <div class="margin-10px about-possition about-title-size">ASSIGNMENT</div>
                            <p class="lead about-content-style">
                                Teacher can easily assigned the task to student at anytime and anywhere through the website. On the other hand, the student can also download and upload the files through this website.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white-box box-sizing">
                            <img src="{{ asset('img/exam.png') }}" class="about-icon-size about-possition" width="20%">
                            <div class="margin-10px about-possition about-title-size">Quiz</div>
                            <p class="lead about-content-style">
                                The quiz will only be accessible within certain period of time and the students can start the quiz at anytime and anywhere. The result will automatically be calculated after the quiz has been completed.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white-box box-sizing">
                            <img src="{{ asset('img/schedule.png') }}" class="about-icon-size about-possition" width="20%">
                            <div class="margin-10px about-possition about-title-size">Schedule</div>
                            <p class="lead about-content-style">
                                Daily planner (i.e. timetable, holiday and exam planner) is accessible 24 hours through Schoolah website.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid" style="background: #99cada" id="contact">
        <div class="container">
            <div class="col-md-12">
                <h2 class="text-center white" style="border-bottom: 3px dotted #faf6dc">FEEDBACK</h2>
                <p class="text-center white">
                    We would greatly appreciate it if you kindly give us some feedback.
                </p>
            </div>
            <div class="col-md-12" style="margin-top: 6em">
                <div class="row">
                    <div class="offset-3 col-md-6 offset-3">
                        <div class="form-group">
                            <textarea :class="'form-control '+error.class.feedback" rows="5" placeholder="Enter feedback" style="resize: none" v-model="formValue.feedback"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-feedback" @click="validateFeedback">Send</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                user: {},
                error: {
                    class: {
                        feedback: ""
                    }
                },
                formValue: {
                    feedback: ""
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
                            if(app.user.role == "teacher" || app.user.role == "student") {
                                if(app.user.is_change_password == 0) {
                                    window.location = "/reset-password"
                                }

                                if(app.user.is_change_password == 1 && app.user.avatar == "img/no-pict") {
                                    window.location = "/reset-avatar"
                                }
                            }
                        }
                    })
                },
                validateFeedback() {
                    if(this.required(this.formValue.feedback)) {
                        this.error.class.feedback = "border-red"
                    }else {
                        this.error.class.feedback = ""
                    }

                    if(this.error.class.feedback == "") {
                        this.addFeedback()
                    }
                },
                resetForm() {
                    this.formValue.feedback = ""
                },
                addFeedback() {
                    axios.post("add-feedback", {
                        "feedback": app.formValue.feedback
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.resetForm()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                }
            }
        })
    </script>
@endsection