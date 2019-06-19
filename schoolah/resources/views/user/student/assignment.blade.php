@extends('layouts.app-admin')

@section('css')
    <style>
        .title-font {
            border-bottom: 6px solid #51a9c5;
            padding-bottom: 6px;
            font-size: 50px;
            color: #51a9c5;
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
        .no-border {
            border: none;
        }
    </style>

@endsection

@section('content')
    <section>
        <div class="ui container mt-5 mb-5">
            <h3 class="text-right text-uppercase title-font mb-5">
                <b>Assignment</b>
            </h3>
            <table class="table bg-white">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(assignment, index) in assignments">
                    <td>@{{ index+1 }}</td>
                    <td>@{{ assignment.name }}</td>
                    <td>@{{ assignment.description }}</td>
                    <td>@{{ assignment.due_date }}</td>
                    <td>
                        <button class="btn btn-primary no-border"
                                @click="downloadAssignment(assignment.question_file)"
                                style="background-color: #50a9c5">
                            <i class="fa fa-download"></i>
                        </button>
                        <button class="btn btn-primary no-border"
                                @click="uploadAssignment(assignment.id)"
                                style="background-color: red"
                                v-if="assignment.status">
                            <i class="fa fa-upload"></i>
                        </button>
                        <button class="btn btn-primary no-border"
                                @click="viewAssignment(assignment.id)"
                                style="background-color: #52d600">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="detail-assignment">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assignment Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <label for="upload" class="w-80" style="cursor: pointer; padding: 0 20%;">
                                <div class="upload-picture">
                                    <i class="fa fa-upload" style="font-size: 4rem"></i>
                                    <input type="file" id="upload" @change="onFileChange" hidden>
                                </div>
                            </label>
                            <div class="mt-2" v-show="fileName">
                                @{{ fileName }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" :disabled="!canUpload" @click="uploadAnswer()"><i class="fa fa-save"></i> Upload</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="history-assignment">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <table class="table bg-white">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(assignment, index) in historyAssignments">
                                    <td>@{{ index+1 }}</td>
                                    <td>@{{ assignment.created_at }}</td>
                                    <td>
                                        <button class="btn btn-primary no-border" @click="downloadHistoryAssignment(assignment.answer_file)">
                                            <i class="fa fa-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: "#app",
            data: {
                assignments: [],
                canUpload: false,
                selectedAssignmentId: null,
                uploadAssignmentValue: null,
                fileName: null,
                historyAssignments: []
            },
            mounted() {
                this.getAssignments()
            },
            methods: {
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
                getAssignments() {
                    axios.get("{{ url('student/get-assignment-by-grade') }}")
                    .then(function (response) {
                        if(response.status) {
                            let baseUrl = window.location.origin
                            for(let i=0; response.data.length > i; i++) {
                                response.data[i].question_file = response.data[i].question_file.replace('public',baseUrl)
                                response.data[i].due_date = moment(response.data[i].due_date).format("D MMMM Y")
                                console.log(moment(response.data[i].due_date) > moment())
                                if(moment(response.data[i].due_date) > moment())
                                    response.data[i].status = true
                                else
                                    response.data[i].status = false
                            }
                            app.assignments = response.data
                        }
                    })
                },
                downloadAssignment(link) {
                    window.open(link, '_blank')
                },
                uploadAssignment(id) {
                    this.selectedAssignmentId = id
                    $("#detail-assignment").modal("show")
                },
                uploadAnswer() {
                    let requestData = new FormData()
                    requestData.append('file', app.uploadAssignmentValue)
                    requestData.append('id', app.selectedAssignmentId)

                    Swal.showLoading()
                    axios.post("{{ url('student/upload-assignment') }}", requestData)
                    .then(function (response) {
                        if(response.status) {
                            app.popUpSuccess()
                            app.resetForm()
                            $("#detail-assignment").modal("hide")
                        }
                    })
                },
                onFileChange(e) {
                    this.canUpload = true
                    this.uploadAssignmentValue = e.target.files[0]
                    this.fileName = this.uploadAssignmentValue.name
                },
                resetForm() {
                    this.canUpload = false
                    this.fileName = null
                },
                viewAssignment(id) {
                    $("#history-assignment").modal("show")

                    axios.get("{{ url('student/get-history-assignment') }}/"+id)
                    .then(function (response) {
                        if(response.status) {
                            let baseUrl = window.location.origin
                            for(let i=0; response.data.length > i; i++) {
                                response.data[i].answer_file = response.data[i].answer_file.replace('public',baseUrl)
                                response.data[i].created_at = moment(response.data[i].created_at).format("D MMMM Y")
                            }
                            app.historyAssignments = response.data
                        }
                    })
                },
                downloadHistoryAssignment(link) {
                    window.open(link, '_blank')
                }
            }
        })
    </script>
@endsection