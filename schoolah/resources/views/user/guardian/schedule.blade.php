@extends('layouts.app-admin')

@section('css')

@endsection

@section('content')
<section class="schedule">
    <div class="ui container mt-5 mb-5">
        <h3 class="text-right text-uppercase title-font mb-5">
            <b>Schedule</b>
        </h3>
        <div class="ui grid bg-white">
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
                loading: true
            },
            mounted() {
                this.getStudentId()
            },
            methods: {
                getStudentId() {
                    this.getDataCalender(Cookies.get("student_id"))
                },
                getDataCalender(studentId) {
                    console.log(studentId)
                    axios.get("{{ url('guardian/get-schedule') }}/"+studentId)
                    .then(function (response) {
                        if(response.status) {
                            app.loading = false
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
                        events: this.studentSchedules
                    });
                }
            }
        })
    </script>
@endsection