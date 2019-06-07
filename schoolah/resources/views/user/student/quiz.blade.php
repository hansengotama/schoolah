@extends('layouts.app-admin')

@section('css')
    <style>
        .quiz-container {
            margin: 0 auto 1.5em;
            background-image: url("/img/inactive.jpeg");
            background-size: 100%;
            background-repeat: no-repeat;
            /*border: 1px solid black;*/
            text-align: center;
            height: 250px;
            width: 250px;
            line-height: 380px;
            cursor: pointer;
            border-radius: 50%;
        }
        .quiz-container:hover {
            background-image: url("/img/active.jpeg");
            background-size: 100%;
            background-repeat: no-repeat;
        }
        .quiz-container-text {
            text-transform: uppercase;
            color: white;
        }
        .title-font {
            border-bottom: 6px solid #51a9c5;
            padding-bottom: 6px;
            font-size: 50px;
            color: #51a9c5;
        }
        .container-button {
            float: left;
        }
        .point-box {
            border: 1px solid black;
            padding: 12px;
        }
        .start-quiz {
            border-radius: 50%;
            border: 1px solid #d7eef5;
            width: 250px;
            height: 250px;
            line-height: 250px;
            cursor: pointer;
            text-align: center;
            margin: 0 auto;
            background: #d7eef5;
            text-transform: uppercase;
            font-size: 24px;
        }
        .start-quiz:hover,
        .start-quiz:after,
        .start-quiz:focus {
            border: 1px solid #feec48;
            background: #feec48;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .background-answer {
            background: #99cada;
        }
    </style>
@endsection

@section('content')
    <div id="quiz">
        <div class="container mt-5" v-show="page=='quiz'">
            <h3 class="text-right text-uppercase title-font">
                <b>Quiz</b>
            </h3>
            <div class="col-md-12 p-0 mt-5 mb-5">
                <div class="row">
                    <div class="col-md-4" v-for="course in courses" @click="goQuiz(course)">
                        <div class="quiz-container">
                            <span class="quiz-container-text">
                                <b>@{{ course.course.name }}</b>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5" v-show="page=='go-quiz'">
            <div class="text-right text-uppercase title-font">
                <b class="container-button"><i class="fa fa-arrow-left" style="cursor: pointer; font-size: 28px" @click="backToQuiz()"></i></b>
                <b>@{{ selectedCourse.course.name }}</b>
            </div>
            <div class="col-md-12 p-0 mt-5 mb-5">
                <div class="row float-right">
                    <div class="col-md-12">
                        <span class="point-box">
                            Total Point: <b>2030</b>
                        </span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="start-quiz mt-5" @click="startQuiz()">
                            <b>Start Quiz</b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12" style="margin-top: 5em">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Masukan Hidup</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>213</td>
                                    <td>213</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="page=='quiz-time'">
            <div class="container mt-5">
{{--                <h4>Start Quiz</h4>--}}
                <div class="col-md-12">
                    <div class="row" v-for="(question, index) in packet.question">
                        <div class="mb-4">
                            <div><b>@{{ index+1 }}. @{{ question.text }}</b></div>
                            <div v-for="(choice, indexChoice) in question.question_choices" class="mx-3">
                                <div v-if="indexChoice==0" :class="'cursor-pointer question-' + question.id" @click = "getAnswer(question.id, choice.id)" :id="'answer-' + choice.id">a. @{{ choice.text }}</div>
                                <div v-if="indexChoice==1" :class="'cursor-pointer question-' + question.id" @click = "getAnswer(question.id, choice.id)" :id="'answer-' + choice.id">b. @{{ choice.text }}</div>
                                <div v-if="indexChoice==2" :class="'cursor-pointer question-' + question.id" @click = "getAnswer(question.id, choice.id)" :id="'answer-' + choice.id">c. @{{ choice.text }}</div>
                                <div v-if="indexChoice==3" :class="'cursor-pointer question-' + question.id" @click = "getAnswer(question.id, choice.id)" :id="'answer-' + choice.id">d. @{{ choice.text }}</div>
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
                page: "quiz",
                selectedCourse: {
                    course: {
                        name: ""
                    }
                },
                packet: {}
            },
            mounted() {
                this.getCourses()
                window.onbeforeunload = () => {
                    if(this.page == "quiz-time")
                        return "Are you sure?"

                }
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
                goQuiz(course) {
                    this.selectedCourse = course
                    this.page = "go-quiz"
                    this.getHistory()
                },
                getHistory() {

                },
                backToQuiz() {
                    this.page = "quiz"
                },
                startQuiz() {
                    axios.get("{{ url('student/get-quiz-packet') }}/"+app.selectedCourse.grade.level+"/"+app.selectedCourse.course.id)
                    .then(function (response) {
                        if(response.status) {
                            app.packet = response.data
                            console.log(app.packet)
                            app.quizTime()
                        }
                    })
                },
                quizTime() {
                    this.page = "quiz-time"
                },
                getAnswer(questionId, choiceId) {
                    let object = $(".question-"+questionId)
                    $.each( object, function( key, value ) {
                        if($(value).hasClass("background-answer"))
                            $(value).removeClass("background-answer")
                    });

                    $("#answer-"+choiceId).addClass("background-answer")
                },
            },
        })
    </script>
@endsection