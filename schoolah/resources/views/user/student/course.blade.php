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
        body {
            background-image: url("https://schoolah.dev.net/img/2.jpeg");
            background-size: 100%;
            background-repeat: repeat;
            background-position: unset;
            background-attachment: fixed;
        }
        body:after{
            opacity: 0.5;
            z-index: -9999;
        }
        .teacher-detail-container {
            background: white;
            padding: 10px;
        }
        .teacher-detail-container h4 {
            color: #50a9c5;
            font-weight: bolder;
        }
        .tab-style-left {
            padding: 8px 0;
            border: 3px solid #50a9c5;
            border-top-left-radius: 16px;
            cursor: pointer;
            background-color: white;
            text-transform: uppercase;
            border-right: none;
            font-weight: 600;
        }
        .tab-style-left.active {
            background-color: #50a9c5;
            color :white;
        }
        .tab-style-right {
            padding: 8px 0;
            border: 3px solid #50a9c5;
            border-top-right-radius: 16px;
            cursor: pointer;
            background-color: white;
            text-transform: uppercase;
            font-weight: 600;
        }
        .tab-style-right.active {
            background-color: #50a9c5;
            color :white;
        }
        .container-details {
            border: 3px solid #4fa9c5;
            height: 500px;
            width: 100%;
            border-top: none;
            background-color: white;
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;
            position: relative;
        }
        .table-padding {
            margin-top: 3em;
            padding: 0 5em;
            height: 400px;
            overflow: auto;
        }
        .btn-download {
            border: none;
            background-color: #50a9c5;
            border-radius: 5px;
            padding: 8px 12px;
        }
        .vertical-align-middle {
            vertical-align: middle !important;
        }
        .forum-chat {
            margin-top: 3em;
            padding: 0 2em;
            height: 363px;
            overflow: auto;
        }
        .chat-send {
            position: absolute;
            bottom: 25px;
            left: 25px;
            border: 2px solid #b1acac;
            height: 2.5rem;
            z-index: 99999;
            width: 90%;
            border-radius: 15px;
            padding: 10px;
        }
        .button-chat {
            background-color: #b1acac;
            border: 2px solid #b1acac;
            position: absolute;
            bottom: 25px;
            right: 25px;
            height: 2.5rem;
            z-index: 99999;
            width: 8%;
            border-bottom-right-radius: 15px;
            border-top-right-radius: 15px;
            cursor: pointer;
        }
        .p-chat {
            background-color: #f0f0ff;
            padding: 9px;
            border-radius: 15px;
            margin-bottom: 0;
        }
        input:before,
        input:after,
        input:focus {
            outline: none;
            border: 2px solid #b1acac;
        }
        button:before,
        button:after,
        button:focus {
            outline: none;
            border: 2px solid #b1acac;
        }
    </style>
@endsection

@section('content')
    <div id="course">
        <div v-if="page=='course'">
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
        <div v-else-if="page=='course-detail'">
            <div class="ui container mt-5 mb-5">
                <h3 class="text-right text-uppercase title-font mb-5">
                    <b class="float-left"><i class="fa fa-arrow-left" style="cursor: pointer; font-size: 28px" @click="backToCourse()"></i></b>
                    <b>@{{ selectedCourseTeacher.course.name }}</b>
                </h3>
            </div>
            <div class="container">
                <div class="teacher-detail-container">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 text-center text-uppercase mt-2"><h4>Teacher</h4></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <img :src="selectedCourseTeacher.teacher.avatar" width="100%">
                            </div>
                            <div class="col-md-4" style="margin: auto">
                                <p>
                                    <b>Name : </b>@{{ selectedCourseTeacher.teacher.user.name }} <br>
                                    <b>Teacher Code : </b>@{{ selectedCourseTeacher.teacher.teacher_code }} <br>
                                    <b>Address : </b>@{{ selectedCourseTeacher.teacher.user.address }} <br>
                                    <b>Phone Number : </b>@{{ selectedCourseTeacher.teacher.user.phone_number }} <br>
                                    <b>Email : </b>@{{ selectedCourseTeacher.teacher.user.email }}
                                </p>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 mb-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 text-center tab-style-left" :class="{ active : tab=='material' }" @click="goToMaterial()">
                                Material
                            </div>
                            <div class="col-md-6 text-center tab-style-right" :class="{ active : tab=='forum' }" @click="goToForum()">
                                Forum
                            </div>
                        </div>
                        <div class="row">
                            <div class="container-details">
                                <div v-if="tab=='material'">
                                    <div class="table-padding">
                                        <table class="table table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th width="10%">No</th>
                                                    <th width="60%">Title</th>
                                                    <th width="20%">Created At</th>
                                                    <th width="10%">Download</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(material, index) in materials">
                                                    <td class="vertical-align-middle">@{{ index+1 }}</td>
                                                    <td class="vertical-align-middle">@{{ material.title }}</td>
                                                    <td class="vertical-align-middle">@{{ material.createdAt }}</td>
                                                    <td>
                                                        <button class="btn-download">
                                                            <i class="fa fa-download" style="color: white" @click="downloadMaterial(material.file)"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div v-if="tab=='forum'">
                                    <div class="forum-chat">
                                        <div v-for="chat in forumChats" class="mb-2">
                                            <b>@{{ chat.user.name }}</b>
                                            <b style="float: right"><small>@{{ chat.created_at }} || @{{ chat.time_created_at }}</small></b>
                                            <div><p class="p-chat">@{{ chat.chat }}</p></div>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="text" class="chat-send" v-model="chat">
                                        <button class="button-chat" @click="sendChat()">
                                            <i class="fa fa-comments"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                selectedCourseTeacher: {},
                page: "course",
                tab: "material",
                materials: {},
                forumChats: {},
                chat: ""
            },
            mounted() {
                this.getCourses()
            },
            methods: {
                required(value) {
                    return (value.length < 1) ? true : false
                },
                getCourses() {
                    axios.get("{{ url('student/get-course') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.courses = response.data
                        }
                    })
                },
                getCourseDetail(grade_id, course_id) {
                    var pageURL = $(location).attr("href");

                    axios.get("{{ url('student/get-teacher-profile') }}/"+grade_id+"/"+course_id)
                    .then(function (response) {
                        if(response.status) {
                            if(response.data.teacher.avatar == "img/no-pict")
                                response.data.teacher.avatar = pageURL.replace('student/course-view',response.data.teacher.avatar + ".png")
                            else {
                                response.data.teacher.avatar = response.data.teacher.avatar.replace('public', '')
                                response.data.teacher.avatar = pageURL.replace('student/course-view',response.data.teacher.avatar)
                            }
                            app.selectedCourseTeacher = response.data
                            app.getAllMaterials()
                            app.getAllChats()
                            app.page = "course-detail"
                        }
                    })
                },
                backToCourse() {
                    this.page = "course"
                },
                goToMaterial() {
                    this.tab = "material"
                },
                goToForum() {
                    this.tab = "forum"
                },
                getAllMaterials() {
                    axios.get("{{ url('student/get-material') }}/"+this.selectedCourseTeacher.id)
                    .then(function (response) {
                        if(response.status) {
                            let materials = response.data
                            let baseUrl = window.location.origin
                            for(let i=0; response.data.length > i; i++) {
                                response.data[i].file = response.data[i].file.replace('public',baseUrl)
                            }
                            app.materials = materials
                        }
                    })
                },
                getAllChats() {
                    axios.get("{{ url('student/get-all-chat') }}/"+this.selectedCourseTeacher.id)
                    .then(function (response) {
                        if(response.status) {
                            for(let i=0; response.data.length > i; i++) {
                                response.data[i].created_at = moment(response.data[i].created_at).format("D MMMM Y")
                                response.data[i].time_created_at = moment(response.data[i].created_at).format("hh:mm:ss")
                            }
                            app.forumChats = response.data
                        }
                    })
                },
                sendChat() {
                    let noMessage = this.required(this.chat)
                    if(!noMessage) {
                        axios.post("{{ url("student/send-chat") }}", {
                            chat: app.chat,
                            teacher_class_id: app.selectedCourseTeacher.id
                        })
                        .then(function (response) {
                            if(response.status) {
                                app.getAllChats()
                                app.resetChat()
                            }
                        })
                    }
                },
                resetChat() {
                    this.chat = ""
                },
                downloadMaterial(link) {
                    window.open(link, '_blank')
                }
            }
        })
    </script>
@endsection