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
                            <div class="margin-10px about-possition about-title-size">ASD</div>
                            <p class="lead about-content-style">
                                It is a long established fact that a reader will be distracted by the readable content
                                of a page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web
                                page editors now use Lorem Ipsum as their default model text, and a search for 'lorem
                                ipsum' will uncover many web sites still in their infancy. Various versions have evolved
                                over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white-box box-sizing">
                            <img src="{{ asset('img/exam.png') }}" class="about-icon-size about-possition" width="20%">
                            <div class="margin-10px about-possition about-title-size">ASD</div>
                            <p class="lead about-content-style">
                                It is a long established fact that a reader will be distracted by the readable content
                                of a page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web
                                page editors now use Lorem Ipsum as their default model text, and a search for 'lorem
                                ipsum' will uncover many web sites still in their infancy. Various versions have evolved
                                over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white-box box-sizing">
                            <img src="{{ asset('img/schedule.png') }}" class="about-icon-size about-possition" width="20%">
                            <div class="margin-10px about-possition about-title-size">ASD</div>
                            <p class="lead about-content-style">
                                It is a long established fact that a reader will be distracted by the readable content
                                of a page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web
                                page editors now use Lorem Ipsum as their default model text, and a search for 'lorem
                                ipsum' will uncover many web sites still in their infancy. Various versions have evolved
                                over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
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
                <h2 class="text-center white" style="border-bottom: 3px dotted #faf6dc">CONTACT</h2>
                <p class="text-center white">
                    We would greatly appreciate it if you kindly give us some feedback.
                </p>
            </div>
            <div class="col-md-12" style="margin-top: 6em">
                <div class="row">
                    <div class="col-md-6 border-right-with-dot">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter name" name="name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter phone number" name="phoneNumber">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your phone number with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="5" id="comment" placeholder="Enter feedback" style="resize: none" name="feedback"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-feedback">Send</button>
                    </div>
                    <div class="col-md-6" style="margin: auto">
                        <div class="col-md-12 margin-top-responsive">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
    <script>

    </script>
@endsection