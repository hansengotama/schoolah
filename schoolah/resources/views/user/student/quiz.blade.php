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
            border-radius: 25px;
            padding-left: 15px;
        }
        .timer-duration {
            font-size: 32px;
            margin-bottom: 5px;
            color: green;
        }
        .check-question.notanswered{
            background-color: #fce8e6;
        }
        .correctanswer {
            background: #99cada;
            border-radius: 25px;
            padding-left: 15px;
        }
        .wronganswer {
            background: red;
            border-radius: 25px;
            padding-left: 15px;
        }
        .notanswer {
            background: #d88db4;
            border-radius: 25px;
            padding-left: 15px;
        }
        .pad-left-15 {
            padding-left: 15px;
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
    </style>
@endsection

@section('content')
    <div id="quiz">
        <div id="image-action" data-sad="{{ asset("/img/sad.png") }}" data-happy="{{ asset("/img/happy.png") }}" hidden></div>
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
                            Total Point: <b>@{{ totalScore }}</b>
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
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Point</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(history, index) in histories">
                                    <td>@{{ index+1 }}</td>
                                    <td>@{{ history.created_at }}</td>
                                    <td>@{{ history.time }}</td>
                                    <td>@{{ history.score }}</td>
                                    <td><button class="btn btn-primary" @click="viewHistory(history.student_packet_id)">View</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="page=='quiz-time'">
            <div class="text-center mt-5">
                <b><h3>Quiz @{{ selectedCourse.course.name }}</h3></b>
            </div>
            <div class="container mt-5">
                <div class="col-md-2">
                    <div class="text-center timer-duration" style="position: fixed; margin-left: 31em;">
                        @{{ timer.text }}
                    </div>
                </div>
                <div class="col-md-10 p-0">
                    <div class="mb-4" v-for="(question, index) in packet.question">
                        <div class="check-question" :id="index+1">
                            <div :id="'question' + question.id" class="question-text"><b>@{{ index+1 }}. @{{ question.text }}</b></div>
                            <div v-for="(choice, indexChoice) in question.question_choices" class="pad-left" @click = "getAnswer(question.id, choice.id)">
                                <div v-if="indexChoice==1" :class="'pad-left-15 cursor-pointer question-' + question.id" :id="'answer-' + choice.id">b. @{{ choice.text }}</div>
                                <div v-if="indexChoice==0" :class="'pad-left-15 cursor-pointer question-' + question.id" :id="'answer-' + choice.id">a. @{{ choice.text }}</div>
                                <div v-if="indexChoice==2" :class="'pad-left-15 cursor-pointer question-' + question.id" :id="'answer-' + choice.id">c. @{{ choice.text }}</div>
                                <div v-if="indexChoice==3" :class="'pad-left-15 cursor-pointer question-' + question.id" :id="'answer-' + choice.id">d. @{{ choice.text }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary mb-5 mt-5" style="width: 60%" @click="validateAnswer()">Submit</button>
                </div>
            </div>
        </div>
        <div class="container mt-5" v-show="page=='result-view'">
            <div class="text-right text-uppercase title-font">
                <b class="container-button"><i class="fa fa-arrow-left" style="cursor: pointer; font-size: 28px" @click="backToGoQuiz()"></i></b>
                <b>HISTORY</b>
            </div>
            <div class="container mt-5">
                <div :class="'mb-4 '" v-for="(question, index) in historyDetails">
                    <div :id="'question-history-' + question.id" class="question-text"><b>@{{ index+1 }}. @{{ question.question.text }}</b></div>
                    <div v-for="(choice, indexChoice) in question.question.question_choices" class="pad-left">
                        <div v-if="indexChoice==0" :class="'pad-left-15 question-history-' + question.id" :id="'answer-' + choice.id">a. @{{ choice.text }}</div>
                        <div v-if="indexChoice==1" :class="'pad-left-15 question-history-' + question.id" :id="'answer-' + choice.id">b. @{{ choice.text }}</div>
                        <div v-if="indexChoice==2" :class="'pad-left-15 question-history-' + question.id" :id="'answer-' + choice.id">c. @{{ choice.text }}</div>
                        <div v-if="indexChoice==3" :class="'pad-left-15 question-history-' + question.id" :id="'answer-' + choice.id">d. @{{ choice.text }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var minute = 5

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
                packet: {},
                questionAnswerData: [],
                timer: {
                    time: moment().add(minute, "minutes"),
                    text: "00:00"
                },
                questionLength: 0,
                startDuration: true,
                histories: {},
                totalScore: 0,
                historyDetails: {}
            },
            mounted() {
                this.getCourses()
                window.onbeforeunload = () => {
                    if(this.page == "quiz-time")
                        return "Are you sure?"
                }
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
                    axios.get("{{ url('student/get-packet-history') }}/"+app.selectedCourse.course.id)
                    .then(function (response) {
                        if(response.status) {
                            app.totalScore = response.data.total_score
                            app.histories = response.data.student_packets
                        }
                    })
                },
                backToQuiz() {
                    this.page = "quiz"
                },
                startQuiz() {
                    axios.get("{{ url('student/get-quiz-packet') }}/"+app.selectedCourse.grade.level+"/"+app.selectedCourse.course.id)
                    .then(function (response) {
                        if(response.status) {
                            app.packet = response.data
                            app.quizTime()
                            app.questionLength = response.data.question.length
                            app.packet.question.forEach(function (data) {
                                app.questionAnswerData.push({
                                    "question_id" : data.id,
                                    "choice_id" : null
                                })
                            })
                        }else {
                            Swal.fire(
                                'Sorry :(',
                                'The question is unavailable.',
                                'info'
                            )
                        }
                    })
                    .catch(function (error) {
                        Swal.fire(
                            'Sorry :(',
                            'The question is unavailable.',
                            'info'
                        )
                    })
                },
                quizTime() {
                    this.page = "quiz-time"
                    this.startTimer()
                    this.resetTimer()
                },
                startTimer() {
                    let diff = moment.duration(this.timer.time.diff(moment()))
                    let minute = diff.get('minutes') > 9 ? diff.get('minutes') : '0'+diff.get('minutes')
                    let second = diff.get('seconds') > 9 ? diff.get('seconds') : '0'+diff.get('seconds')

                    if(parseInt(minute) < 1)
                        $(".timer-duration").css("color", "red")


                    this.timer.text = minute+' : '+second
                    if(!(minute <= 0 && second <= 0)) {
                        if(this.startDuration)
                            setTimeout(() => this.startTimer(), 100);
                    }
                    else {
                        Swal.fire({
                            position: 'top-right',
                            type: 'warning',
                            title: "Time's up. Your answer(s) have been automatically saved! :)",
                            showConfirmButton: false,
                            timer: 4000
                        })
                        this.submitAnswer()
                    }

                },
                validateAnswer() {
                    let numberQuestion = []
                    this.questionAnswerData.forEach((data, key) => {
                        if(data.choice_id == null) {
                            numberQuestion.push(key+1)
                        }
                    })

                    if(numberQuestion.length == 0) {
                        this.submitAnswer()
                    }else {
                        numberQuestion.forEach(function (number) {
                            $(".check-question#"+number).addClass("notanswered")
                        })

                        Swal.fire(
                            'Not all question are filled in',
                            'Please recheck! :)',
                            'info'
                        )
                    }
                },
                submitAnswer() {
                    let data = {}
                    data.packet_id = app.packet.id
                    data.question_answers = app.questionAnswerData

                    axios.post("{{ url('student/check-answer') }}", data)
                    .then(function (response) {
                        if(response.status) {
                            app.startDuration = false
                            let data = response.data

                            let title = ""
                            let text = ""
                            let image = ""
                            if(data.percentage < 50) {
                                title = "Try Harder!"
                                text = "<div class='mb-3'> You need to lear more! </div>" +
                                    "<b style='color: green'>True: "+ data.result_true + "</b> | "+
                                    "<b style='color: red'>False: "+ data.result_false + "</b>"
                                image = $("#image-action").data("sad")
                            }else {
                                title = "Good Job!"
                                text = "<div class='mb-3'> Keep It Up! </div>" +
                                    "<b style='color: green'>True: "+ data.result_true + "</b> | "+
                                    "<b style='color: red'>False: "+ data.result_false + "</b>"
                                image = $("#image-action").data("happy")
                            }

                            Swal.fire({
                                title: title,
                                html: text,
                                imageUrl: image,
                                imageWidth: 300,
                                imageHeight: 300,
                                imageAlt: 'Custom image',
                                animation: false,
                                closeOnConfirm: false,
                                allowOutsideClick: false
                            })
                            .then(function (result) {
                                if(result.value) {
                                    app.page = "go-quiz"
                                    app.getHistory()
                                }
                            })
                        }
                    })
                },
                getAnswer(questionId, choiceId) {
                    let object = $(".question-"+questionId)
                    $.each( object, function( key, value ) {
                        if($(value).hasClass("background-answer"))
                            $(value).removeClass("background-answer")
                    });

                    $("#answer-"+choiceId).addClass("background-answer")
                    $("#answer-"+choiceId).parent(".pad-left").parent(".check-question").removeClass("notanswered")

                    this.getAnswerData(questionId, choiceId)
                },
                getAnswerData(questionId, choiceId) {
                    let data = this.findInArrayOfObject("question_id", questionId, this.questionAnswerData)

                    data.choice_id = choiceId
                },
                resetTimer() {
                    this.timer.time = moment().add(minute, "minutes")
                    this.timer.text = "00:00"
                },
                viewHistory(studentPacketId) {
                    this.page = "result-view"

                    axios.get("{{ url('student/get-packet-history-detail') }}/"+studentPacketId)
                    .then(function (response) {
                        if(response.status) {
                            app.historyDetails = response.data
                            setTimeout(function() {
                                app.historyDetails.forEach(function (data) {
                                    if(data.question_choice)
                                        if(data.question_choice.is_answer == "1")
                                            $("#answer-"+data.question_choice.id+".question-history-"+data.id).addClass("correctanswer")
                                        else
                                            $("#answer-"+data.question_choice.id+".question-history-"+data.id).addClass("wronganswer")


                                    data.question.question_choices.forEach(function (choice) {
                                        if(choice.is_answer == "1" && data.question_choice)
                                            $("#answer-"+choice.id+".question-history-"+data.id).addClass("correctanswer")
                                        else if(choice.is_answer == "1")
                                            $("#answer-"+choice.id+".question-history-"+data.id).addClass("notanswer")
                                    })

                                })
                            }, 250);
                        }
                    })
                },
                backToGoQuiz() {
                    this.page = "go-quiz"
                }
            },
            beforeDestroy() {
                this.resetTimer()
            }
        })
    </script>
@endsection