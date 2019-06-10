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
    </style>
@endsection

@section('content')
    <div class="ui container mt-5 mb-5">
        <h3 class="text-right text-uppercase title-font mb-5">
            <b>Schedule</b>
        </h3>
        <div class="ui grid">
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
                            console.log(app.studentSchedules)
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