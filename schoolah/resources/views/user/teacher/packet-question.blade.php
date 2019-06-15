@extends('layouts.app-admin')

@section('css')
    <style>
        .pr-0 {
            padding-right: 0;
        }
        .isAnswer {
            color: green;
        }
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
    </style>
@endsection

@section('content')
    <section class="content">
        <div id="teacher-packet" v-if="this.page=='teacherPacket'">
            <div class="container">
                <div class="row justify-content-center display-block">
                    <div class="ui container mt-5 mb-5">
                        <h3 class="text-right text-uppercase title-font mb-5">
                            <b>Packet</b>
                        </h3>
                    </div>
                    <div class="table-margin bg-white col-md-12">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Packet Name</th>
                                <th scope="col">Course Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Total Used Question</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(teacherPacket, index) in teacherPackets">
                                <td>@{{ teacherPacket.number }}</td>
                                <td>@{{ teacherPacket.name }}</td>
                                <td>@{{ teacherPacket.course.name }}</td>
                                <td>@{{ teacherPacket.type }}</td>
                                <td>@{{ teacherPacket.total_used_question }}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs" @click="viewQuestion(teacherPacket.id)">View Question</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="question" v-else>
            <div class="container">
                <div class="row justify-content-center display-block">
                    <div class="ui container mt-5 mb-5">
                        <h3 class="text-right text-uppercase title-font mb-5">
                            <b class="float-left"><i class="fa fa-arrow-left" style="cursor: pointer; font-size: 28px" @click="backToPacket()"></i></b>
                            <b>Manage Question</b>
                        </h3>
                    </div>
                    <div class="table-margin col-md-12 bg-white">
                        <div class="font-weight-600 mb-4">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-question" @click="resetForm()">
                                <i class="fa fa-plus"></i> Add Question
                            </button>
                        </div>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Choice 1</th>
                                    <th scope="col">Choice 2</th>
                                    <th scope="col">Choice 3</th>
                                    <th scope="col">Choice 4</th>
                                    <th scope="col">Action</th>
                                <tr>
                            </thead>
                            <tbody>
                                <tr v-for="(question, index) in questions">
                                    <td>@{{ index+1 }}</td>
                                    <td>@{{ question.text }}</td>
                                    <td v-for="answer in question.question_choices" :class="{ isAnswer: answer.is_answer == 1 }">@{{ answer.text }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" data-toggle="modal" @click="fillEditForm(question.id)">Edit</button>
                                        <button type="button" class="btn btn-danger" @click="confirmDeleteQuestion(question.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-question">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Question</label>
                                <textarea :class="'form-control '+ error.class.question" v-model="formValue.question"></textarea>
                                <div class="red">@{{ error.text.question }}</div>
                            </div>
                            <div class="form-group">
                                <label>Answers</label>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-1 radio">
                                            <input type="radio" value="1" v-model="formValue.answer">
                                        </div>
                                        <div class="col-md-11 pr-0">
                                            <input type="text" :class="'form-control '+ error.class.choice1" v-model="formValue.choice1">
                                            <div class="red">@{{ error.text.choice1 }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-1 radio">
                                            <input type="radio" value="2" v-model="formValue.answer">
                                        </div>
                                        <div class="col-md-11 pr-0">
                                            <input type="text" :class="'form-control '+ error.class.choice2" v-model="formValue.choice2">
                                            <div class="red">@{{ error.text.choice2 }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-1 radio">
                                            <input type="radio" value="3" v-model="formValue.answer">
                                        </div>
                                        <div class="col-md-11 pr-0">
                                            <input type="text" :class="'form-control '+ error.class.choice3" v-model="formValue.choice3">
                                            <div class="red">@{{ error.text.choice3 }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-1 radio">
                                            <input type="radio" value="4" v-model="formValue.answer">
                                        </div>
                                        <div class="col-md-11 pr-0">
                                            <input type="text" :class="'form-control '+ error.class.choice4" v-model="formValue.choice4">
                                            <div class="red">@{{ error.text.choice4 }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="validateForm('add')">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-question">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Question</label>
                                <textarea :class="'form-control '+ error.class.question" v-model="formValue.question"></textarea>
                                <div class="red">@{{ error.text.question }}</div>
                            </div>
                            <div class="form-group">
                                <label>Answers</label>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-1 radio">
                                            <input type="radio" value="1" v-model="formValue.answer">
                                        </div>
                                        <div class="col-md-11 pr-0">
                                            <input type="text" :class="'form-control '+ error.class.choice1" v-model="formValue.choice1">
                                            <div class="red">@{{ error.text.choice1 }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-1 radio">
                                            <input type="radio" value="2" v-model="formValue.answer">
                                        </div>
                                        <div class="col-md-11 pr-0">
                                            <input type="text" :class="'form-control '+ error.class.choice2" v-model="formValue.choice2">
                                            <div class="red">@{{ error.text.choice2 }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-1 radio">
                                            <input type="radio" value="3" v-model="formValue.answer">
                                        </div>
                                        <div class="col-md-11 pr-0">
                                            <input type="text" :class="'form-control '+ error.class.choice3" v-model="formValue.choice3">
                                            <div class="red">@{{ error.text.choice3 }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="row">
                                        <div class="col-md-1 radio">
                                            <input type="radio" value="4" v-model="formValue.answer">
                                        </div>
                                        <div class="col-md-11 pr-0">
                                            <input type="text" :class="'form-control '+ error.class.choice4" v-model="formValue.choice4">
                                            <div class="red">@{{ error.text.choice4 }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="validateForm('edit')">Edit</button>
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
                teacherPackets: {},
                selectedPacketId: 0,
                page: "teacherPacket",
                formValue: {
                    question: "",
                    answer: 1,
                    choice1: "",
                    choice2: "",
                    choice3: "",
                    choice4: "",
                },
                error: {
                    class: {
                        question: "",
                        choice1: "",
                        choice2: "",
                        choice3: "",
                        choice4: "",
                    },
                    text: {
                        question: "",
                        choice1: "",
                        choice2: "",
                        choice3: "",
                        choice4: "",
                    }
                },
                questions: [{
                    question_choices: [{
                        text: "",
                        is_answer: ""
                    }],
                    text: ""
                }],
                selectedQuestionId: 0
            },
            mounted() {
                this.getTeacherPacket()
            },
            methods: {
                required(value) {
                    return (value.length < 1) ? true : false
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
                getTeacherPacket() {
                    axios.get("{{ url('teacher/get-packet-question') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.teacherPackets = response.data

                            let index = 1
                            app.teacherPackets.forEach((teacherPacket) => {
                                teacherPacket.number = index
                                index++
                            })
                        }
                    })
                },
                viewQuestion(selectedPacketId) {
                    this.page = "question"
                    this.selectedPacketId = selectedPacketId
                    this.getAllQuestion()
                },
                resetForm() {
                    this.formValue.question = ""
                    this.formValue.answer = 1
                    this.formValue.choice1 = ""
                    this.formValue.choice2 = ""
                    this.formValue.choice3 = ""
                    this.formValue.choice4 = ""
                },
                validateForm(action) {
                    if(this.required(this.formValue.question)) {
                        this.error.class.question = "border-red"
                        this.error.text.question = "question must be filled"
                    }else {
                        this.error.class.question = ""
                        this.error.text.question = ""
                    }

                    if(this.required(this.formValue.choice1)) {
                        this.error.class.choice1 = "border-red"
                        this.error.text.choice1 = "choice must be selected"
                    }else {
                        this.error.class.choice1 = ""
                        this.error.text.choice1 = ""
                    }

                    if(this.required(this.formValue.choice2)) {
                        this.error.class.choice2 = "border-red"
                        this.error.text.choice2 = "choice must be selected"
                    }else {
                        this.error.class.choice2 = ""
                        this.error.text.choice2 = ""
                    }

                    if(this.required(this.formValue.choice3)) {
                        this.error.class.choice3 = "border-red"
                        this.error.text.choice3 = "choice must be selected"
                    }else {
                        this.error.class.choice3 = ""
                        this.error.text.choice3 = ""
                    }

                    if(this.required(this.formValue.choice4)) {
                        this.error.class.choice4 = "border-red"
                        this.error.text.choice4 = "choice must be selected"
                    }else {
                        this.error.class.choice4 = ""
                        this.error.text.choice4 = ""
                    }

                    if(this.error.class.question == ""
                        && this.error.class.choice1 == ""
                        && this.error.class.choice2 == ""
                        && this.error.class.choice3 == ""
                        && this.error.class.choice4 == "") {
                        if(action == "add") {
                            $("#add-question").modal("toggle")
                            this.addQuestion()
                        }

                        if(action == "edit") {
                            $("#edit-question").modal("toggle")
                            this.editQuestion()
                        }
                    }
                },
                addQuestion() {
                    axios.post("{{ url('teacher/add-question') }}", {
                        packetId: this.selectedPacketId,
                        question: this.formValue.question,
                        answer: this.formValue.answer,
                        choices: {
                            0: this.formValue.choice1,
                            1: this.formValue.choice2,
                            2: this.formValue.choice3,
                            3: this.formValue.choice4
                        }
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.getAllQuestion()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                editQuestion() {
                    axios.post("{{ url('teacher/edit-question') }}", {
                        questionId: this.selectedQuestionId,
                        question: this.formValue.question,
                        answer: this.formValue.answer,
                        choices: {
                            0: this.formValue.choice1,
                            1: this.formValue.choice2,
                            2: this.formValue.choice3,
                            3: this.formValue.choice4
                        }
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.getAllQuestion()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                getAllQuestion() {
                    axios.get("{{ url('teacher/get-all-question') }}/"+this.selectedPacketId)
                    .then(function (response) {
                        if(response.status) {
                            app.questions = response.data
                        }
                    })
                },
                fillEditForm(questionId) {
                    $("#edit-question").modal('show')
                    this.selectedQuestionId = questionId

                    axios.get("{{ url('teacher/get-question') }}/" + questionId)
                    .then(function (response) {
                        if(response.status) {
                            app.formValue.question = response.data.text
                            app.formValue.choice1 = response.data.question_choices[0].text
                            app.formValue.choice2 = response.data.question_choices[1].text
                            app.formValue.choice3 = response.data.question_choices[2].text
                            app.formValue.choice4 = response.data.question_choices[3].text

                            let flag = 1
                            for(let i=0; i < response.data.question_choices.length; i++) {
                                if(response.data.question_choices[i].is_answer == 1) {
                                    app.formValue.answer = flag
                                }

                                flag++
                            }
                        }
                    })
                },
                confirmDeleteQuestion(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            this.deleteQuestion(id)
                        }
                    })
                },
                deleteQuestion(questionId) {
                    axios.post("{{ url('teacher/delete-question') }}", {
                        questionId: questionId
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.getAllQuestion()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .error(function (error) {
                        app.popUpError()
                    })
                },
                backToPacket() {
                    this.page = "teacherPacket"
                }
            }
        })
    </script>
@endsection