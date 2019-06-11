@extends('layouts.app-admin')

@section('css')
    <style>
        .title-font {
            border-bottom: 6px solid #51a9c5;
            padding-bottom: 6px;
            font-size: 50px;
            color: #51a9c5;
        }
        .course-container {
            text-align: center;
            border: 1px solid #afdef5;
            border-radius: 15px;
            padding: 10px;
            cursor: pointer;
            background-color: #afdef5;
            text-transform: uppercase;
            font-weight: 600;
        }
        .course-container:hover {
            background: rgba(179,220,237,1);
            background: -moz-linear-gradient(left, rgba(179,220,237,1) 0%, rgba(41,184,229,1) 50%, rgba(179,220,237,1) 89%, rgba(179,220,237,1) 94%, rgba(188,224,238,1) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(179,220,237,1)), color-stop(50%, rgba(41,184,229,1)), color-stop(89%, rgba(179,220,237,1)), color-stop(94%, rgba(179,220,237,1)), color-stop(100%, rgba(188,224,238,1)));
            background: -webkit-linear-gradient(left, rgba(179,220,237,1) 0%, rgba(41,184,229,1) 50%, rgba(179,220,237,1) 89%, rgba(179,220,237,1) 94%, rgba(188,224,238,1) 100%);
            background: -o-linear-gradient(left, rgba(179,220,237,1) 0%, rgba(41,184,229,1) 50%, rgba(179,220,237,1) 89%, rgba(179,220,237,1) 94%, rgba(188,224,238,1) 100%);
            background: -ms-linear-gradient(left, rgba(179,220,237,1) 0%, rgba(41,184,229,1) 50%, rgba(179,220,237,1) 89%, rgba(179,220,237,1) 94%, rgba(188,224,238,1) 100%);
            background: linear-gradient(to right, rgba(179,220,237,1) 0%, rgba(41,184,229,1) 50%, rgba(179,220,237,1) 89%, rgba(179,220,237,1) 94%, rgba(188,224,238,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b3dced', endColorstr='#bce0ee', GradientType=1 );
        }
    </style>
@endsection

@section('content')
    <div id="course">
        <div class="ui container mt-5 mb-5">
            <h3 class="text-right text-uppercase title-font mb-5">
                <b>Course</b>
            </h3>
        </div>
        <div class="container">
            <div class="col-md-12">
                <div class="row" style="margin: 0 auto">
                    <div class="col-md-4 mb-3 centered" v-for="course in courses">
                        <div class="course-container" @click="getCourseDetail(course.grade.id, course.course.id)">
                            @{{ course.course.name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                courses: {},
                selectedCourseTeacher: {}
            },
            mounted() {
                this.getCourses()
            },
            methods: {
                getCourses() {
                    axios.get("{{ url('student/get-course') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.courses = response.data
                        }
                    })
                },
                getCourseDetail(grade_id, course_id) {
                    axios.get("{{ url('student/get-teacher-profile') }}/"+grade_id+"/"+course_id)
                    .then(function (response) {
                        if(response.status) {
                            app.selectedCourseTeacher = response.data
                            console.log(app.selectedCourseTeacher)
                        }
                    })
                }
            }
        })
    </script>
@endsection