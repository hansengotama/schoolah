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
                        <h3>Manage Teacher</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-teacher" @click="resetForm()">
                                <i class="fa fa-plus"></i> Add Teacher
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
                            <th scope="col">Code</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Address</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(teacher, index) in teachers">
                                <td>@{{ teacher.number }}</td>
                                <td>@{{ teacher.name }}</td>
                                <td>@{{ teacher.teacher_code }}</td>
                                <td>@{{ teacher.email }}</td>
                                <td>@{{ teacher.phone_number }}</td>
                                <td>@{{ teacher.address }}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-teacher" @click="fillEditForm(teacher.id)">Edit</button>
                                    <button class="btn btn-danger btn-xs" @click="confirmDeleteTeacher(teacher.id)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-teacher">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" :class="'form-control '+error.class.name" v-model="formValue.name">
                            <div class="red">@{{ error.text.name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" :class="'form-control '+error.class.email" v-model="formValue.email">
                            <div class="red">@{{ error.text.email }}</div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" :class="'form-control '+error.class.phoneNumber" v-model="formValue.phoneNumber">
                            <div class="red">@{{ error.text.phoneNumber }}</div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea :class="'form-control '+error.class.address" cols="20" rows="3" v-model="formValue.address"></textarea>
                            <div class="red">@{{ error.text.address }}</div>
                        </div>
                        <div class="form-group">
                            <label>Teacher Code</label>
                            <input type="text" :class="'form-control '+error.class.teacherCode" v-model="formValue.teacherCode">
                            <div class="red">@{{ error.text.teacherCode }}</div>
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
    <div class="modal fade" id="edit-teacher">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" :class="'form-control '+error.class.name" v-model="formValue.name">
                            <div class="red">@{{ error.text.name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" :class="'form-control '+error.class.email" v-model="formValue.email">
                            <div class="red">@{{ error.text.email }}</div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" :class="'form-control '+error.class.phoneNumber" v-model="formValue.phoneNumber">
                            <div class="red">@{{ error.text.phoneNumber }}</div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea :class="'form-control '+error.class.address" cols="20" rows="3" v-model="formValue.address"></textarea>
                            <div class="red">@{{ error.text.address }}</div>
                        </div>
                        <div class="form-group">
                            <label>Teacher Code</label>
                            <input type="text" :class="'form-control '+error.class.teacherCode" v-model="formValue.teacherCode">
                            <div class="red">@{{ error.text.teacherCode }}</div>
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
                teachers: {},
                formValue: {
                    name: "",
                    email: "",
                    phoneNumber: "",
                    address: "",
                    teacherCode: "",
                },
                error: {
                    text: {
                        name: "",
                        email: "",
                        phoneNumber: "",
                        address: "",
                        teacherCode: "",
                    },
                    class: {
                        name: "",
                        email: "",
                        phoneNumber: "",
                        address: "",
                        teacherCode: "",
                    }
                },
                selectedTeacherId: null
            },
            mounted() {
                this.getAllTeachers()
            },
            methods: {
                required(value) {
                    return (value.length < 1) ? true : false
                },
                isNumber(value) {
                    var regex = /^[0-9.,]+$/
                    return !regex.test(value)
                },
                emailFormat(value) {
                    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
                    return !regex.test(String(value).toLowerCase())
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
                getAllTeachers() {
                    axios.get('{{ url('staff/get-all-teacher') }}')
                    .then(function (response) {
                        let index = 1
                        if(response.status == 200) {
                            app.teachers = response.data
                            app.teachers.forEach((teacher) => {
                                teacher.number = index
                                index++
                            })
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                resetForm() {
                    this.formValue.name = ""
                    this.formValue.email = ""
                    this.formValue.phoneNumber = ""
                    this.formValue.address = ""
                    this.formValue.teacherCode = ""
                },
                validateForm(action) {
                    if(this.required(this.formValue.name)) {
                        this.error.class.name = "border-red"
                        this.error.text.name = "name must be filled"
                    }else {
                        this.error.class.name = ""
                        this.error.text.name = ""
                    }

                    if(this.required(this.formValue.email)) {
                        this.error.class.email = "border-red"
                        this.error.text.email = "email must be filled"
                    }else if(this.emailFormat(this.formValue.email)){
                        this.error.class.email = "border-red"
                        this.error.text.email = "email must be formatted correctly"
                    }else {
                        this.error.class.email = ""
                        this.error.text.email = ""
                    }

                    if(this.required(this.formValue.phoneNumber)) {
                        this.error.class.phoneNumber = "border-red"
                        this.error.text.phoneNumber = "phone number must be filled"
                    }else if(this.isNumber(this.formValue.phoneNumber)) {
                        this.error.class.phoneNumber = "border-red"
                        this.error.text.phoneNumber = "phone number must be number"
                    }else {
                        this.error.class.phoneNumber = ""
                        this.error.text.phoneNumber = ""
                    }

                    if(this.required(this.formValue.address)) {
                        this.error.class.address = "border-red"
                        this.error.text.address = "address must be filled"
                    }else {
                        this.error.class.address = ""
                        this.error.text.address = ""
                    }

                    if(this.required(this.formValue.teacherCode)) {
                        this.error.class.teacherCode = "border-red"
                        this.error.text.teacherCode = "teacher code must be filled"
                    }else {
                        this.error.class.teacherCode = ""
                        this.error.text.teacherCode = ""
                    }

                    if(this.error.class.name == "" && this.error.class.email  == "" && this.error.class.phoneNumber  == "" && this.error.class.address == "" && this.error.class.teacherCode == ""){
                        if(action == "add") {
                            $('#add-teacher').modal('toggle')
                            this.createTeacher()
                        }

                        if(action == "edit") {
                            $('#edit-teacher').modal('toggle')
                            this.editTeacher()
                        }
                    }
                },
                createTeacher() {
                    Swal.showLoading()
                    axios.post("add-teacher", app.formValue)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.getAllTeachers()
                            app.resetForm()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                fillEditForm(id) {
                    axios.post("{{ url('staff/get-teacher') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            let data = response.data
                            app.formValue.name = data.name
                            app.formValue.email = data.email
                            app.formValue.phoneNumber = data.phone_number
                            app.formValue.teacherCode = data.teacher_code
                            app.formValue.address = data.address
                            app.selectedTeacherId = data.id
                        }else {
                            $('#edit-teacher').modal('toggle')
                            this.popUpError()
                        }
                    })
                    .catch(function () {
                        $('#edit-teacher').modal('toggle')
                        this.popUpError()
                    })
                },
                editTeacher() {
                    Swal.showLoading()
                    axios.post('{{ url('staff/edit-teacher') }}', {
                        "id": app.selectedTeacherId,
                        "name": app.formValue.name,
                        "email": app.formValue.email,
                        "address": app.formValue.address,
                        "phoneNumber": app.formValue.phoneNumber,
                        "teacherCode": app.formValue.teacherCode,
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.getAllTeachers()
                            app.resetForm()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                confirmDeleteTeacher(id) {
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
                            this.deleteTeacher(id)
                        }
                    })
                },
                deleteTeacher(id) {
                    Swal.showLoading()
                    axios.post("{{ url('staff/delete-teacher') }}", {
                        id: id
                    })
                    .then((response) => {
                        if(response.status == 200) {
                            this.getAllTeachers()
                            this.popUpSuccess()
                        }else {
                            this.popUpError()
                        }
                    })
                    .catch((error) => {
                        this.popUpError()
                    })
                }
            }
        })
    </script>
@endsection