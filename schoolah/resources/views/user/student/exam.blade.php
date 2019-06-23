@extends('layouts.app-admin')

@section('css')
    <style>
        .title-font {
            border-bottom: 6px solid #51a9c5;
            padding-bottom: 6px;
            font-size: 50px;
            color: #51a9c5;
        }
        .info-exam {
            background-color: aliceblue;
            padding: 22px;
        }
        .timer {
            position: fixed;
            font-size: 32px;
            margin-left: 29em;
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
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="ui container mt-5 mb-5">
        <div class="text-center" v-show="page=='noexam'">
            <h3>Sorry, you don't have any exam right now.</h3>
        </div>
        <div v-show="page=='examstart'">
            <div class="info-exam">
                <div class="row">
                    <div class="col-md-3">
                        <div>Exam Name</div>
                        <div>Date</div>
                        <div>Start Time</div>
                        <div>End Time</div>
                    </div>
                    <div class="col-md-2">
                        <div><b>@{{ scheduleDetail.name }}</b></div>
                        <div><b>@{{ moment(scheduleDetail.date) }}</b></div>
                        <div><b>@{{ momentTime(scheduleShift.from) }}</b></div>
                        <div><b>@{{ momentTime(scheduleShift.until) }}</b></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="timer">
                    @{{ timer.text }}
                </div>
                <div class="mt-5 col-md-10 p-0">
                    <div :class="'mb-4 check-question'" :id="index+1" v-for="(question, index) in questions">
                        <div :id="'question-' + question.id" class="question-text"><b>@{{ index+1 }}. @{{ question.text }}</b></div>
                        <div v-for="(choice, indexChoice) in question.question_choices" class="pad-left cursor-pointer" @click = "getAnswer(question.id, choice.id)">
                            <div v-if="indexChoice==0" :class="'pad-left-15 question-' + question.id" :id="'answer-' + choice.id">a. @{{ choice.text }}</div>
                            <div v-if="indexChoice==1" :class="'pad-left-15 question-' + question.id" :id="'answer-' + choice.id">b. @{{ choice.text }}</div>
                            <div v-if="indexChoice==2" :class="'pad-left-15 question-' + question.id" :id="'answer-' + choice.id">c. @{{ choice.text }}</div>
                            <div v-if="indexChoice==3" :class="'pad-left-15 question-' + question.id" :id="'answer-' + choice.id">d. @{{ choice.text }}</div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <button class="btn btn-primary" @click="validateAnswer()">Submit</button>
                </div>
            </div>
        </div>
        <div class="text-center" v-show="page=='checkresult'">
            <h3>Thankyou, please wait for your result.</h3>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: "#app",
            data: {
                page: "noexam",
                scheduleDetail: {},
                scheduleShift: {},
                timer: {
                    until: "",
                    text: "00:00:00"
                },
                questions: {},
                questionAnswerData: []
            },
            mounted() {
                this.getExam()
                window.onbeforeunload = () => {
                    if(this.page == "examstart")
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
                moment(date) {
                    return moment(date).format("D MMMM Y")
                },
                momentTime(time) {
                    return moment(time, "hh:mm:ss").format("HH:mm:ss")
                },
                getExam() {
                    axios.get("{{ url('student/get-exam') }}")
                    .then(function (response) {
                        if(response.status) {
                            if(! (Object.keys(response.data).length === 0)) {
                                app.scheduleDetail = response.data.schedule_detail
                                app.scheduleShift = response.data.schedule_shift
                                app.questions = response.data.schedule_detail.schedule_detail_packet.packet.question
                                app.page= "examstart"
                                app.getExamDuration(response.data.schedule_shift)
                                response.data.schedule_detail.schedule_detail_packet.packet.question.forEach(function (data) {
                                    app.questionAnswerData.push({
                                        "question_id" : data.id,
                                        "choice_id" : null
                                    })
                                })
                            }
                        }
                    })
                },
                getExamDuration(scheduleShift) {
                    let from = moment(scheduleShift.until, "hh:mm:ss")
                    this.timer.until = moment(scheduleShift.until, "hh:mm:ss")

                    this.startTimer()
                },
                startTimer() {
                    let diff = moment.duration(this.timer.until.diff(moment()))
                    let hour = diff.get('hours') > 9 ? diff.get('hours') : '0'+diff.get('hours')
                    let minute = diff.get('minutes') > 9 ? diff.get('minutes') : '0'+diff.get('minutes')
                    let second = diff.get('seconds') > 9 ? diff.get('seconds') : '0'+diff.get('seconds')

                    if(hour >= 1)
                        this.timer.text = hour+' : '+ minute+' : '+second
                    else
                        this.timer.text = minute+' : '+second


                    if(!(hour <= 0 && minute <= 0 && second <= 0))
                        setTimeout(() => this.startTimer(), 100)
                    else {
                        Swal.fire({
                            position: 'top-right',
                            type: 'warning',
                            title: "Time's up. Your answer(s) have been automatically saved! :)",
                            showConfirmButton: false,
                            timer: 4000
                        })
                        this.saveAnswer()
                    }
                },
                getAnswer(questionId, choiceId) {
                    let object = $(".question-"+questionId)
                    console.log(object)
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
                saveAnswer() {
                    app.page= "checkresult"

                    let data = {}
                    data.packet_id = app.scheduleDetail.schedule_detail_packet.packet.id
                    data.question_answers = app.questionAnswerData
                    data.exam = true

                    axios.post("{{ url('student/check-answer') }}", data)
                    .then(function (response) {
                        if(response.status) {

                        }
                    })
                },
                validateAnswer() {
                    let numberQuestion = []
                    this.questionAnswerData.forEach((data, key) => {
                        if(data.choice_id == null) {
                            numberQuestion.push(key+1)
                        }
                    })
                    if(numberQuestion.length == 0)
                        this.saveAnswer()
                    else {
                        numberQuestion.forEach(function (number) {
                            $(".check-question#"+number).addClass("notanswered")
                        })

                        Swal.fire(
                            'Not all question are filled in',
                            'Please recheck! :)',
                            'info'
                        )
                    }
                }
            }
        })
    </script>
@endsection