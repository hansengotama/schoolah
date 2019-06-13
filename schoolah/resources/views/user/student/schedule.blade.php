@extends('layouts.app-admin')

@section('css')
    <style>
        .fc-time {
            display: block !important;
        }
        .title-font {
            border-bottom: 6px solid #51a9c5;
            padding-bottom: 6px;
            font-size: 50px;
            color: #51a9c5;
        }
        .fc-other-month {
            background-color: #faf9f8;
        }
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
    </style>
@endsection

@section('content')
    <div class="ui container mt-5 mb-5">
        <h3 class="text-right text-uppercase title-font mb-5">
            <b>Schedule</b>
        </h3>
        <div class="ui grid bg-white">
            <div class="ui sixteen column">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                studentSchedules: []
            },
            mounted() {
                this.getDataCalender()
            },
            methods: {
                getDataCalender() {
                    axios.get("{{ url('student/get-schedule') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.studentSchedules = Object.values(response.data)
                            app.setCalender()
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
                        // showNonCurrentDates: false,
                        events: this.studentSchedules
                    });
                }
            }
        })
    </script>
@endsection