@extends('layouts.app-admin')

@section('css')

@endsection

@section('content')
<section class="content">
    <div id="staff">
        <div class="container">
            <div class="row justify-content-center display-block">
                <div class="mt-5">
                    <div class="col-md-12">
                        <h3>Manage Packet</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-packet" @click="resetForm()">
                                <i class="fa fa-plus"></i> Add Packet
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-4 table-margin">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(packet, index) in packets">
                            <td>@{{ packet.number }}</td>
                            <td>@{{ packet.name }}</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-packet" @click="fillEditForm(packet.id)">Edit</button>
                                <button class="btn btn-danger btn-xs" @click="confirmDeletePacket(packet.id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-packet">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Packet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Course</label>
                            <select :class="'form-control '+error.class.course" v-model="formValue.courseId">
                                <option v-for="studentCode in selectChoice.types" :value=studentCode.id>@{{ studentCode.student_code }}</option>
                            </select>
                            <div class="red">@{{ errorStudent.text.studentCode }}</div>
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
</section>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                packets: {},
                formValue: {
                    courseId: 0,
                    type: "",
                    totalUsedQuestion: 0,
                    name: ""
                },
                error: {
                    text: {
                        name: "",
                        type: "",
                        course: "",
                        totalUsedQuestion: ""
                    },
                    class: {
                        name: "",
                        type: "",
                        course: "",
                        totalUsedQuestion: ""
                    }
                },
                selectChoice: {
                    types: {
                        name: "--select type--",
                        value: 0
                    },
                    courses: {
                        name: "--select course--",
                        value: 0
                    },
                    contributorTeachers: {
                        name: "--select teacher--",
                        value: 0
                    }
                },
            },
            mounted() {
                this.getSelectChoice()
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
                getSelectChoice() {
                    this.getSelectChoiceType()
                    this.getSelectChoiceCourse()
                },
                getSelectChoiceType() {
                    this.selectChoice.types = [{
                        name: "--select type--",
                        value: 0
                    }]

                },
                getSelectChoiceCourse() {
                    this.selectChoice.courses = [{
                        name: "--select course--",
                        value: 0
                    }]

                },
                getSelectChoiceContributorTeacher() {
                    this.selectChoice.contributorTeachers = [{
                        name: "--select teacher--",
                        value: 0
                    }]

                },
                resetForm() {
                    this.formValue.courseId = 0
                    this.formValue.type = ""
                    this.formValue.totalUsedQuestion = 0
                    this.formValue.name = ""
                },
                fillEditForm(id) {

                },
                confirmDeletePacket(id) {
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
                            this.deletePacket(id)
                        }
                    })
                },
                deletePacket(id) {

                },
                validateForm(action) {

                },
            }
        })
    </script>
@endsection