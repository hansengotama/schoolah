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
        .title-font {
            border-bottom: 6px solid #51a9c5;
            padding-bottom: 6px;
            font-size: 50px;
            color: #51a9c5;
        }
        .teacher-class-container {
            margin: 0 auto 1.5em;
            background-image: url("/img/inactive.jpeg");
            background-size: 100%;
            background-repeat: no-repeat;
            text-align: center;
            height: 250px;
            width: 250px;
            line-height: 355px;
            cursor: pointer;
            border-radius: 50%;
            position: relative;
        }
        .teacher-class-container:hover {
            background-image: url("/img/active.jpeg");
            background-size: 100%;
            background-repeat: no-repeat;
        }
        .teacher-course-container-text {
            text-transform: uppercase;
            color: white;
        }
        .teacher-class-container-text {
            text-transform: uppercase;
            color: white;
            position: absolute;
            top: 26px;
            left: 50px;
        }
        .tab-style-right {
            padding: 8px 0;
            border: 3px solid #50a9c5;
            border-top-right-radius: 16px;
            cursor: pointer;
            border-left: none;
            background-color: white;
            text-transform: uppercase;
            font-weight: 600;
        }
        .tab-style-center {
            padding: 8px 0;
            border: 3px solid #50a9c5;
            cursor: pointer;
            background-color: white;
            text-transform: uppercase;
            font-weight: 600;
        }
        .tab-style-left {
            padding: 8px 0;
            border: 3px solid #50a9c5;
            border-top-left-radius: 16px;
            border-right: none;
            cursor: pointer;
            background-color: white;
            text-transform: uppercase;
            font-weight: 600;
        }
        .activeTab {
            color: white;
            background-color: #50a9c5;
        }
        .container-details {
            border: 3px solid #4fa9c5;
            height: 500px;
            width: 100%;
            border-top: none;
            background-color: white;
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;
        }
        .btn-class {
            background-color: #4fa9c5;
            border: none;
        }
        .btn-class:hover,
        .btn-class:before,
        .btn-class:active,
        .btn-class:focus {
            background-color: #4fa9c5;
            border: none;
            color: white;
        }
        #assignment {
            margin: 30px 40px;
        }
    </style>
@endsection

@section('content')
    <div id="class">
        <div class="ui container mt-5 mb-5" v-if="page=='class'">
            <h3 class="text-right text-uppercase title-font mb-5">
                <b>Class</b>
            </h3>
            <div class="col-md-12 p-0 mt-5 mb-5">
                <div class="row">
                    <div class="col-md-4" v-for="teacherClass in teacherClasses">
                        <div class="teacher-class-container" @click="goToClass(teacherClass.id)">
                            <div class="teacher-course-container-text">
                                <b>@{{ teacherClass.course.name }}</b>
                            </div>
                            <span class="teacher-class-container-text">
                                <div style="width: 150px">
                                    <i>@{{ teacherClass.grade.name }}</i>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui container mt-5 mb-5" v-if="page=='class-detail'">
            <h3 class="text-right text-uppercase title-font mb-5">
                <b class="float-left"><i class="fa fa-arrow-left" style="cursor: pointer; font-size: 28px" @click="backToClass()"></i></b>
                <b>@{{ selectedTeacherClass.course.name }} | @{{ selectedTeacherClass.grade.name }}</b>
            </h3>
            <div class="col-md-12 bg-white">
                <div class="row">
                    <div class="col-md-4 text-center tab-style-left" @click="changeTab('assignment')" :class="{ activeTab : tab=='assignment' }">
                        Assignment
                    </div>
                    <div class="col-md-4 text-center tab-style-center" @click="changeTab('material')" :class="{ activeTab : tab=='material' }">
                        Material
                    </div>
                    <div class="col-md-4 text-center tab-style-right" @click="changeTab('absence')" :class="{ activeTab : tab=='absence' }">
                        Absence
                    </div>
                </div>
                <div class="row" v-if="tab=='assignment'">
                    <div class="container-details">
                        <div id="assignment">
                            <button class="btn btn-primary btn-class">
                                <i class="fa fa-plus"></i> Assignment
                            </button>
                            <table class="table table-striped table-sm mt-3">
                                <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="40%">Title</th>
                                    <th width="30%">Due Date</th>
                                    <th width="10%">Download</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="vertical-align-middle">1</td>
                                    <td class="vertical-align-middle">asd</td>
                                    <td class="vertical-align-middle">asd</td>
                                    <td>
                                        <button class="btn-download">
                                            <i class="fa fa-download" style="color: white"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="tab=='material'">
                    <div class="container-details">
                        material
                    </div>
                </div>
                <div class="row" v-if="tab=='absence'">
                    <div class="container-details">
                        absence
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
                teacherClasses: {},
                page: "class",
                selectedTeacherClass: {},
                tab: "assignment"
            },
            mounted() {
                this.getTeacherClasses()
            },
            methods: {
                findInArrayOfObject(key, value, array) {
                    let response = false

                    for (var i = 0; i < array.length; i++) {
                        if (array[i][key] === value)
                            response = array[i]
                    }

                    return response
                },
                getTeacherClasses() {
                    axios.get("{{ url('teacher/get-teacher-class') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.teacherClasses = response.data
                        }
                    })
                },
                goToClass(teacher_class_id) {
                    this.page = "class-detail"
                    this.selectedTeacherClass = this.findInArrayOfObject("id", teacher_class_id, this.teacherClasses)

                },
                backToClass() {
                    this.page = "class"
                },
                changeTab(tab) {
                    this.tab = tab
                }
            }
        })
    </script>
@endsection