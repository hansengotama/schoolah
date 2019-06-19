<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('img/logo-white.jpeg') }}">
    <title>Schoolah</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Font google -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
    <!-- Full Calender -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.css" rel="stylesheet">
    <!--  Custom CSS -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
    <style>
        .nav-item.active {
            background-color: #86c2d6;
        }
        .header-fixed {
            position: fixed;
            min-width: 100%;
            clear: both;
            z-index: 9999;
        }
        #footer {
            clear: both;
            position: absolute;
            bottom: 0;
        }
        .bg-white {
            background-color: white;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-softblue navbar-padding {{ (Request::route()->getName() == 'home') ? 'header-fixed' : '' }} ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="{{ url('img/logo-rgb.png') }}" alt=" " width="45px" />
            </a>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                @if(Auth::user()->role == 'admin')
                    <ul class="navbar-nav">
                        <li class="nav-item  {{ (Request::route()->getName() == 'manage-school-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-school-view') }}">School <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item  {{ (Request::route()->getName() == 'feedback-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('feedback-view') }}">Feedback <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                @endif
                @if(Auth::user()->role == 'staff')
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-teacher-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-teacher-view') }}">Teacher <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-student-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-student-view') }}">Student <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-guardian-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-guardian-view') }}">Guardian <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'staff-manage-class-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('staff-manage-class-view') }}">Class <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'staff-manage-class-schedule-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('staff-manage-class-schedule-view') }}">Schedule<span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-course-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-course-view') }}">Course <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-schedule-shift-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-schedule-shift-view') }}">Shift <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-packet-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-packet-view') }}">Packet<span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-tuition-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-tuition-view') }}">Tuition<span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-period-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-period-view') }}">Period<span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                @endif
                @if(Auth::user()->role == 'teacher')
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-class-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-class-view') }}">Class <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-packet-question-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-packet-question-view') }}">Packet Question <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-schedule-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-schedule-view') }}">Schedule <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'manage-forum-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('manage-forum-view') }}">Forum <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                @endif
                @if(Auth::user()->role == 'student')
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'student-schedule-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('student-schedule-view') }}">Schedule <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'student-quiz-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('student-quiz-view') }}">Quiz <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'tuition-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('tuition-view') }}">Tuition <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'assignment-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('assignment-view') }}">Assignment <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'course-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('course-view') }}">Course<span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item {{ (Request::route()->getName() == 'absence-view') ? 'active' : '' }}">
                            <a class="nav-link white" href="{{ route('absence-view') }}">Absence<span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                @endif
            </div>
            <div class="navbar-text">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hi, {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @if(Auth::user()->role != "admin")
                                <a class="dropdown-item" href="{{ url('edit-profile-view') }}">Edit Profile</a>
                            @endif
                            <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        @yield('content')
    </div>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <!-- DataTable -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.11/dist/sweetalert2.all.min.js"></script>
    <!-- Axios -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    <!-- Full Calender -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.js"></script>

    @yield('js')
    <script>
        $(".navbar-toggler").click(function () {
            $(".navbar-text").find(".nav-link.dropdown-toggle.white").toggle()
        })
    </script>
</body>
</html>
