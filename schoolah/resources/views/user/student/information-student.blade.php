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
        .cursor-pointer {
            cursor: pointer;
        }
        .press-here {
            position: absolute;
            top: 200px;
            right: 0;
            height: 42px;
            width: 50px;
            background-color: #99cada;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
            cursor: pointer;
            z-index: 99999;
        }
        .cursor-here {
            margin-top: 9px;
            font-size: 25px;
            margin-left: 13px;
            color: white;
            z-index: 999;
        }
        .pressed {
            position: absolute;
            top: 100px;
            right: 0;
            z-index: 0;
            height: 42px;
            width: 150px;
            background-color: #99cada;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
            cursor: pointer;
        }
        .course-menu {
            background: rgb(188, 212, 220);
            padding: 10px 8px;
            font-weight: 600;
            color: white;
            border-left: 2px solid #99cada;
        }
        .course-menu:nth-child(1) {
            border-top-left-radius: 15px;
        }
        .course-menu:last-child {
            border-bottom-left-radius: 15px;
        }
        .course-menu:hover {
            background-color: #99cada;
        }
        .bg-white {
            background-color: white;
        }
        .course-container {
            padding: 15px;
        }
        .attendance-container {
            border: 3px solid #99cada;
            border-top-left-radius: 15px;
            padding: 15px;
        }
        .exam-score-container {
            border: 3px solid #99cada;
            border-top-right-radius: 15px;
            padding: 15px;
        }
        .exam-score-body-container {
            border-bottom-right-radius: 15px;
            min-height: 500px;
            border: 3px solid #99cada;
            border-top: none;
        }
        .attendance-body-container {
            border-bottom-left-radius: 15px;
            min-height: 500px;
            border: 3px solid #99cada;
            border-top: none;
        }
    </style>
@endsection

@section('content')
    <div class="ui- mt-5 mb-5" style="padding: 0 220px">
        <div class="press-here" v-show="!show" @click="showMenu()"><i class="fa fa-arrow-left cursor-here"></i></div>
        <div class="press-here" v-show="show" @click="showMenu()"><div><i class="fa fa-arrow-right cursor-here"></i></div></div>
        <div class="pressed" v-show="show">
            <div v-for="course in courses" class="course-menu">
                <div class="cursor-pointer" @click="chooseCourse(course)">
                    @{{ course.course.name }}
                </div>
            </div>
        </div>

        <div v-if="selectedCourse" class="bg-white">
            <div style="padding: 15px; border-radius: 15px">
                <h3 style="font-weight: 700;">@{{ selectedCourse.course.name }}</h3>

                <div class="course-container">
                    <div class="row">
                        <div class="col-md-7 attendance-container mr-5">
                            <div style="font-size: 20px">Attendance</div>
                        </div>
                        <div class="col-md-4 exam-score-container">
                            <div style="font-size: 20px">Exam Score</div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 mr-5 attendance-body-container">
                            <div v-if="checkAttendance">
                                <div class="mt-2">
                                    <div>
                                        <b>Present: @{{ attendance.present }}</b>
                                        <b style="float: right">Total: @{{ attendance.total }}</b>
                                    </div>
                                    <div><b>Absence: @{{ attendance.absence }}</b></div>
                                    <div><b>Permit: @{{ attendance.permit }}</b></div>
                                    <div><b>Sick: @{{ attendance.sick }}</b></div>
                                </div>
                                <table class="mt-2 table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Session</th>
                                            <th>Status</th>
                                            <th>Day</th>
                                            <th>Order</th>
                                            <th>Absence At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="data in attendanceData">
                                            <td>@{{ data.session }}</td>
                                            <td>@{{ data.status }}</td>
                                            <td>@{{ data.schedule_class.day }}</td>
                                            <td>@{{ data.schedule_class.order }}</td>
                                            <td>@{{ moment(data.created_at) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <div class="mt-2">You've never attend this course.</div>
                            </div>
                        </div>
                        <div class="col-md-4 exam-score-body-container">
                            <div v-if="checkExamScore">
                                <table class="mt-2 table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Packet Id</th>
                                            <th>Name</th>
                                            <th>Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="data in examScoreData">
                                            <td>@{{ data.packet_id }}</td>
                                            <td>@{{ data.packet.name }}</td>
                                            <td>@{{ data.score }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2" v-else>
                                You've never taken this course exam before.
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: "#app",
            data: {
                courses: [],
                show: false,
                selectedCourse: null,
                attendanceData: [],
                examScoreData: [],
                checkAttendance: false,
                checkExamScore: false,
                attendance: {
                    sick: 0,
                    permit: 0,
                    absence: 0,
                    present: 0,
                    total: 0
                }
            },
            mounted() {
                this.getAllCourse()
            },
            methods: {
                showMenu() {
                    this.show = !this.show
                },
                moment(date) {
                    return moment(date).format("D MMMM Y")
                },
                getAllCourse() {
                    axios.get("{{ url('student/get-course') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.courses = response.data
                            app.selectedCourse = response.data[0]
                            app.chooseCourse(response.data[0])
                        }
                    })
                },
                chooseCourse(course) {
                    this.selectedCourse = course
                    this.getAttendance(course)
                    this.getExamScore(course)
                },
                getAttendance(course) {
                    let courseId = course.course_id
                    let gradeId = course.grade_id

                    axios.get("{{ url('student/get-attendance-student') }}/"+ gradeId + "/" + courseId)
                    .then(function (response) {
                        if(response.status) {
                            app.attendanceData = response.data

                            if(response.data.length > 0)
                                app.checkAttendance = true
                            else
                                app.checkAttendance = false

                            app.getAttendanceAttribute(response.data)
                        }
                    })
                },
                getExamScore(course) {
                    let courseId = course.course_id

                    axios.get("{{ url('student/get-exam-score-student') }}/" + courseId)
                    .then(function (response) {
                        if(response.status) {
                            app.examScoreData = response.data

                            if(response.data.length > 0)
                                app.checkExamScore = true
                            else
                                app.checkExamScore = false
                        }
                    })
                },
                getAttendanceAttribute(attendance) {
                    this.attendance.sick = 0
                    this.attendance.permit = 0
                    this.attendance.absence = 0
                    this.attendance.present = 0
                    this.attendance.total = attendance.length

                    for(let i=0; i<attendance.length; i++) {
                        if(attendance[i].status == "sick") {
                            this.attendance.sick = this.attendance.sick + 1
                        }else if(attendance[i].status == "permit") {
                            this.attendance.permit = this.attendance.permit + 1
                        }else if(attendance[i].status == "absence") {
                            this.attendance.absence = this.attendance.absence + 1
                        }else if(attendance[i].status == "present"){
                            this.attendance.present = this.attendance.present + 1
                        }
                    }
                }
            }
        })
    </script>
@endsection