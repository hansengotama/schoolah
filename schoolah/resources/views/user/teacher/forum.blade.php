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
        .btn-download {
            border: none;
            background-color: #50a9c5;
            border-radius: 5px;
            padding: 8px 12px;
            color: white;
        }
        .chat-container:nth-child(odd) {
            background-color: #f0f0ff;
            padding: 1.4em;
            font-size: 24px;
            cursor: pointer;
        }
        .chat-container:nth-child(odd):hover {
            background-color: #fffa5b;
        }
        .chat-container {
            background-color: #dbd9ff;
            padding: 1.4em;
            font-size: 24px;
            cursor: pointer;
        }
        .chat-container:hover {
            background-color: #fffa5b;
        }
        .chat-container:last-child {
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;
        }
        .chat-container:first-child {
            border-top-right-radius: 15px;
            border-top-left-radius: 15px;
        }
        .chat-container-inside {
            padding: 15px;
            background-color: #f0f0ff;
        }
        .chat-container-inside:nth-child(0) {
            margin-top: 20px;
            border-top-right-radius: 15px;
            border-top-left-radius: 15px;
        }
        .chat-container-inside-me {
            padding: 15px;
            margin-top: 20px;
            background-color: #f0f0ff;
            width: 100%;
        }
        .container-chat {
            height: 40em;
            background-color: beige;
            border-radius: 15px;
            position: relative;
        }
        .input-text-chat {
            width: 90%;
            border-radius: 15px;
            position: absolute;
            z-index: 99999;
            bottom: 25px;
            left: 25px;
            height: 2.5rem;
            padding: 10px;
            border: 2px solid #b1acac;
        }
        .input-text-chat:before,
        .input-text-chat:after,
        .input-text-chat:focus {
            outline: none;
            border: 2px solid #b1acac;
        }
        .button-chat:before,
        .button-chat:after,
        .button-chat:focus {
            outline: none;
            border: 2px solid #b1acac;
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
        .scroll-chat {
            height: 35rem;
            overflow-y: auto;
            padding-top: 15px;
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
    <div id="forum">
        <div class="container">
            <div class="mt-5">
                <div class="col-md-12" v-show="page=='forum'">
                    <div>
                        <h3 class="text-right text-uppercase title-font mb-5">
                            <b>FORUM CHAT</b>
                        </h3>
                    </div>
                    <div class="mt-5 mb-5">
                        <div class="chat-container" v-for="teacherClass in teacherClasses" @click="goToChat(teacherClass)">
                            @{{ teacherClass.grade.name }} | @{{ teacherClass.course.name }}
                        </div>
                    </div>
                </div>
                <div class="col-md-12" v-show="page=='chat'">
                    <div>
                        <h3 class="text-right text-uppercase title-font mb-5">
                            <b class="float-left"><i class="fa fa-arrow-left" style="cursor: pointer; font-size: 28px" @click="backToForum()"></i></b>
                            <b>@{{ selectedTeacherClass.grade.name }} (@{{ selectedTeacherClass.course.name }})</b>
                        </h3>
                    </div>
                    <div class="col-md-12 mt-5 container-chat">
                        <div class="scroll-chat" id="scroll-chat">
                            <div class="chat-container-inside" v-for="forumChat in forumChats">
                                <div><h4><b>@{{ forumChat.user.name }}</b></h4></div>
                                <div>@{{ forumChat.chat }}</div>
                                <div><small style="font-size: 65%">@{{ forumChat.created_at }} | @{{ forumChat.time_created_at }}</small></div>
                            </div>
                            <div id="bottom-chat"></div>
                        </div>
                    </div>

                    <div class="col-md-12 p-0">
                        <input type="text" class="input-text-chat" v-model="chat">
                        <button class="button-chat" @click="sendChat()">
                            <i class="fa fa-comments"></i>
                        </button>
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
                page: "forum",
                selectedTeacherClass: {
                    grade: {
                        name: ""
                    },
                    course: {
                        name: ""
                    }
                },
                chat: "",
                forumChats: {}
            },
            mounted() {
                this.getAllClasses()

            },
            methods: {
                required(value) {
                    return (value.length < 1) ? true : false
                },
                isNumber(value) {
                    var regex = /^[0-9.,]+$/
                    return !regex.test(value)
                },
                popUpError() {
                    swal({
                        heightAuto: true,
                        type: 'error',
                        title: 'Error!',
                    })
                },
                popUpSuccess() {
                    swal({
                        heightAuto: true,
                        type: 'success',
                        title: 'Success!',
                    })
                },
                findInArrayOfObject(key, value, array) {
                    let response = false

                    for (var i = 0; i < array.length; i++) {
                        if (array[i][key] === value)
                            response = array[i]
                    }

                    return response
                },
                getAllClasses() {
                    axios.get("{{ url('teacher/get-teacher-class') }}")
                    .then(function (response) {
                        if (response.status == 200) {
                            app.teacherClasses = response.data
                        }
                    })
                },
                goToChat(objectData) {
                    this.selectedTeacherClass = objectData
                    this.page = "chat"
                    this.getAllChat()
                },
                backToForum() {
                    this.page = "forum"
                    this.resetChat = ""
                },
                resetChat() {
                    this.chat = ""

                },
                getAllChat() {
                    axios.get("{{ url('teacher/get-all-chat') }}/"+app.selectedTeacherClass.id)
                    .then(function (response) {
                        if(response.status) {
                            for(let i=0; response.data.length > i; i++) {
                                response.data[i].time_created_at = moment(response.data[i].created_at).format("hh:mm a")
                                response.data[i].created_at = moment(response.data[i].created_at).format("D MMMM Y")
                            }
                            app.forumChats = response.data
                        }
                    })
                },
                sendChat() {
                    let noMessage = this.required(this.chat)
                    if(!noMessage) {
                        axios.post("{{ url("teacher/send-chat") }}", {
                            chat: app.chat,
                            teacher_class_id: app.selectedTeacherClass.id
                        })
                        .then(function (response) {
                            if(response.status) {
                                app.getAllChat()
                                app.resetChat()
                            }
                        })
                    }
                }
            }
        })
    </script>
@endsection