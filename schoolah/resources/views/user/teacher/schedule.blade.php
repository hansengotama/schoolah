@extends('layouts.app-admin')

@section('css')
    <style>
        .fc-time {
            display: block !important;
        }
    </style>
@endsection

@section('content')
    <div class="ui container mt-5">
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
                teacherSchedules: []
            },
            mounted() {
                this.getDataCalender()
            },
            methods: {
                getDataCalender() {
                    axios.get("{{ url('teacher/get-schedule') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.teacherSchedules = Object.values(response.data)
                            console.log(app.teacherSchedules)
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
                        showNonCurrentDates: false,
                        events: this.teacherSchedules
                    });
                }
            }
        })
    </script>
@endsection