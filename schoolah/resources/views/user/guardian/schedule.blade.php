@extends('layouts.app-admin')

@section('css')
    <style>
        body {
            background-image: url("https://schoolah.dev.net/img/2.jpeg");
            background-size: 100%;
            background-repeat: repeat;
            background-position: unset;
            background-attachment: fixed;
        }
        body:after {
            opacity: 0.5;
            z-index: -9999;
        }
        .title-font {
            border-bottom: 6px solid #51a9c5;
            padding-bottom: 6px;
            font-size: 50px;
            color: #51a9c5;
        }
    </style>
@endsection

@section('content')
<section class="schedule">
    <div class="ui container mt-5 mb-5">
        <h3 class="text-right text-uppercase title-font mb-5 mt-5">
            <b>Schedule</b>
        </h3>
        <div class="col-md-12 p-0 mt-5" style="background-color: #99cada">
            <div style="padding: 8px;">
                <h5>Student Name: <b>@{{ student.user.name }}</b></h5>
                <h5>Student Code: <b>@{{ student.student_code }}</b></h5>
            </div>
        </div>
        <div class="ui grid bg-white mt-5">
            <div class="ui sixteen column">
                <div id="calendar"></div>
            </div>
        </div>
        <div v-if="loading" style="text-align: center">
            <img src="{{ url('img/loading.gif')  }}" width="400px">
        </div>
    </div>
</section>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                studentSchedules: [],
                loading: true,
                student: {}
            },
            mounted() {
                this.getStudentId()
            },
            methods: {
                getStudentId() {
                    this.getDataCalender(Cookies.get("student_id"))
                    this.getStudentData(Cookies.get("student_id"))
                },
                getDataCalender(studentId) {
                    axios.get("{{ url('guardian/get-schedule') }}/"+studentId)
                    .then(function (response) {
                        if(response.status) {
                            app.loading = false
                            app.studentSchedules = Object.values(response.data)
                            app.setCalender()
                        }
                    })
                },
                getStudentData(studentId) {
                    axios.get("{{ url('guardian/get-student-detail') }}/"+studentId)
                    .then(function (response) {
                        if(response.status) {
                            app.student = response.data
                        }
                    })
                },
                setCalender() {
                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        displayEventEnd: true,
                        defaultDate: moment(),
                        navLinks: true,
                        editable: false,
                        eventLimit: true,
                        events: this.studentSchedules
                    });
                }
            }
        })
    </script>
@endsection