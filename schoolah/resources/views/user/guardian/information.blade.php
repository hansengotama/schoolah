@extends('layouts.app-admin')

@section('css')
    <style>
        .container-tuition {
            min-height: 500px;
            border: 1px solid black;
            border-bottom-left-radius: 15px;
            border-top-left-radius: 15px;
        }
        .tuition-inside {
            padding: 20px;
        }
        .container-exam {
            height: 500px;
            overflow-y: auto;
            border: 1px solid black;
            border-bottom-right-radius: 15px;
            border-top-right-radius: 15px;
        }
        .exam-inside {
            padding: 20px;
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
        .bg-white {
            background-color: white;
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
<section class="information">
    <div class="container mt-5">
        <h3 class="text-right text-uppercase title-font">
            <b>Information</b>
        </h3>
        <div class="col-md-12 p-0 mt-5" style="background-color: #99cada">
            <div style="padding: 8px;">
                <h5>Student Name: <b>@{{ student.user.name }}</b></h5>
                <h5>Student Code: <b>@{{ student.student_code }}</b></h5>
            </div>
        </div>
        <div class="col-md-12 mt-5 p-0">
            <div class="row">
                <div class="col-md-6 bg-white">
                    <div class="container-tuition">
                        <div class="tuition-inside">
                            <h4 class="display-block">Attendance</h4>
                            <div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Session</th>
                                            <th>Course</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="data in studentAttendance">
                                            <td>@{{ data.session }}</td>
                                            <td>@{{ data.schedule_class.course.name }}</td>
                                            <td>@{{ moment(data.created_at) }}</td>
                                            <td>@{{ data.status }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bg-white">
                    <div class="container-exam">
                        <div class="exam-inside">
                            <h4 class="display-block">Result</h4>
                            <div>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Packet Id</th>
                                        <th>Packet Name</th>
                                        <th>Type</th>
                                        <th>Score</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="data in studentExamScore">
                                        <td>@{{ data.packet.id }}</td>
                                        <td>@{{ data.packet.name }}</td>
                                        <td>@{{ data.packet.type }}</td>
                                        <td>@{{ data.score }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
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
        var app = new Vue({
            el: '#app',
            data: {
                student: {
                    user: {
                        name: ""
                    },
                    student_code: ""
                },
                studentExamScore: {},
                studentAttendance: {}
            },
            mounted() {
                this.getStudentId()
            },
            methods: {
                moment(date) {
                    return moment(date).format("D MMMM Y")
                },
                getStudentId() {
                    this.getStudentData(Cookies.get("student_id"))
                    this.getStudentExamScore(Cookies.get("student_id"))
                    this.getStudentAttendance(Cookies.get("student_id"))
                },
                getStudentData(studentId) {
                    axios.get("{{ url('guardian/get-student-detail') }}/"+studentId)
                    .then(function (response) {
                        if(response.status) {
                            app.student = response.data
                        }
                    })
                },
                getStudentExamScore(studentId) {
                    axios.get("{{ url('guardian/get-student-exam-and-quiz-score') }}/"+studentId)
                    .then(function (response) {
                        if(response.status) {
                            app.studentExamScore = response.data
                        }
                    })
                },
                getStudentAttendance(studentId) {
                    axios.get("{{ url('guardian/get-student-attendance') }}/"+studentId)
                    .then(function (response) {
                        if(response.status) {
                            app.studentAttendance = response.data
                            console.log(app.studentAttendance)
                        }
                    })
                }
            }
        })
    </script>
@endsection