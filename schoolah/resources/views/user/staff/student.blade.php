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
{{--                        <h3>Manage Student (@{{ selectedClass.name }})</h3>--}}
{{--                        <h5>Guardian Teacher: @{{ teacherName }}</h5>--}}
                        <h3>Manage Student</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-student" @click="resetFormStudent()">
                                <i class="fa fa-plus"></i> Add Student
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
                            <th scope="col">Email</th>
                            <th scope="col">Student Code</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(student, index) in students">
                            <td>@{{ student.number }}</td>
                            <td>@{{ student.name }}</td>
                            <td>@{{ student.email }}</td>
                            <td>@{{ student.studentCode }}</td>
                            <td>@{{ student.address }}</td>
                            <td>@{{ student.phone_number }}</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-student" @click="fillEditFormStudent(student.id)">Edit</button>
                                <button class="btn btn-danger btn-xs" @click="confirmDeleteStudent(student.id)">Delete</button>
                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-student">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" :class="'form-control '+errorStudent.class.name" v-model="formStudent.name">
                            <div class="red">@{{ errorStudent.text.name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Student Code</label>
                            <input type="text" :class="'form-control '+errorStudent.class.studentCode" v-model="formStudent.studentCode">
                            <div class="red">@{{ errorStudent.text.studentCode }}</div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" :class="'form-control '+errorStudent.class.email" v-model="formStudent.email">
                            <div class="red">@{{ errorStudent.text.email }}</div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" :class="'form-control '+errorStudent.class.phoneNumber" v-model="formStudent.phoneNumber">
                            <div class="red">@{{ errorStudent.text.phoneNumber }}</div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea :class="'form-control '+errorStudent.class.address" cols="20" rows="3" v-model="formStudent.address"></textarea>
                            <div class="red">@{{ errorStudent.text.address }}</div>
                        </div>
                        <div class="form-group">
                            <label>Guardian</label>
                            <select type="text" :class="'form-control '+errorStudent.class.guardianId" v-model="formStudent.guardianId">
                                <option v-for="guardian in selectChoice.guardians" :value=guardian.value>@{{ guardian.name }}</option>
                            </select>
                            <div class="red">@{{ errorStudent.text.guardianId }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="formValidateStudent('add')">Add</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-student">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" :class="'form-control '+errorStudent.class.name" v-model="formStudent.name">
                            <div class="red">@{{ errorStudent.text.name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Student Code</label>
                            <input type="text" :class="'form-control '+errorStudent.class.studentCode" v-model="formStudent.studentCode">
                            <div class="red">@{{ errorStudent.text.studentCode }}</div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" :class="'form-control '+errorStudent.class.email" v-model="formStudent.email">
                            <div class="red">@{{ errorStudent.text.email }}</div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" :class="'form-control '+errorStudent.class.phoneNumber" v-model="formStudent.phoneNumber">
                            <div class="red">@{{ errorStudent.text.phoneNumber }}</div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea :class="'form-control '+errorStudent.class.address" cols="20" rows="3" v-model="formStudent.address"></textarea>
                            <div class="red">@{{ errorStudent.text.address }}</div>
                        </div>
                        <div class="form-group">
                            <label>Guardian</label>
                            <select type="text" :class="'form-control '+errorStudent.class.guardianId" v-model="formStudent.guardianId">
                                <option v-for="guardian in selectChoice.guardians" :value=guardian.value>@{{ guardian.name }}</option>
                            </select>
                            <div class="red">@{{ errorStudent.text.guardianId }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="formValidateStudent('edit')">Edit</button>
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
                students: {},
                formStudent: {
                    name: "",
                    email: "",
                    phoneNumber: "",
                    address: "",
                    studentCode: "",
                    guardianId: 0
                },
                selectChoice: {
                    guardians: [{
                        name: "--select guardian--",
                        value: 0
                    }],
                },
                errorStudent: {
                    text: {
                        name: "",
                        email: "",
                        phoneNumber: "",
                        address: "",
                        studentCode: "",
                        guardianId: ""
                    },
                    class: {
                        name: "",
                        email: "",
                        phoneNumber: "",
                        address: "",
                        studentCode: "",
                        guardianId: ""
                    },
                    studentSelected: null
                }
            },
            mounted() {
                this.getGuardianChoice()
                this.getAllStudent()
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
                getGuardianChoice() {
                    axios.get("{{ url('/staff/get-guardian') }}")
                    .then(function (response) {
                        if(response.status == 200) {
                            let guardian = app.selectChoice.guardians
                            let data = response.data
                            for (let i=0; i<data.length; i++) {
                                guardian.push(data[i])
                            }
                        }
                    })
                },
                getAllStudent() {
                    axios.get("{{ url('/staff/get-all-student/0') }}")
                    .then(function (response) {
                        if(response.status == 200) {
                            let index = 1
                            app.students = response.data
                            app.students.forEach((student) => {
                                student.number = index
                                index++
                            })
                        }
                    })
                },
                formValidateStudent(action) {
                    if(this.required(this.formStudent.name)) {
                        this.errorStudent.class.name = "border-red"
                        this.errorStudent.text.name = "name must be filled"
                    }else {
                        this.errorStudent.class.name = ""
                        this.errorStudent.text.name = ""
                    }

                    if(this.required(this.formStudent.email)) {
                        this.errorStudent.class.email = "border-red"
                        this.errorStudent.text.email = "email must be filled"
                    } else if(this.emailFormat(this.formStudent.email)) {
                        this.errorStudent.class.email = "border-red"
                        this.errorStudent.text.email = "email must be formatted correctly"
                    } else {
                        this.errorStudent.class.email = ""
                        this.errorStudent.text.email = ""
                    }

                    if(this.required(this.formStudent.phoneNumber)) {
                        this.errorStudent.class.phoneNumber = "border-red"
                        this.errorStudent.text.phoneNumber = "phone number must be filled"
                    } else if(this.isNumber(this.formStudent.phoneNumber)) {
                        this.errorStudent.class.phoneNumber = "border-red"
                        this.errorStudent.text.phoneNumber = "phone number must be number"
                    } else {
                        this.errorStudent.class.phoneNumber = ""
                        this.errorStudent.text.phoneNumber = ""
                    }

                    if(this.required(this.formStudent.address)) {
                        this.errorStudent.class.address = "border-red"
                        this.errorStudent.text.address = "address must be filled"
                    } else {
                        this.errorStudent.class.address = ""
                        this.errorStudent.text.address = ""
                    }

                    if(this.required(this.formStudent.studentCode)) {
                        this.errorStudent.class.studentCode = "border-red"
                        this.errorStudent.text.studentCode = "student code must be filled"
                    } else {
                        this.errorStudent.class.studentCode = ""
                        this.errorStudent.text.studentCode = ""
                    }

                    if(this.formStudent.guardianId == 0) {
                        this.errorStudent.text.guardianId = "guardian must be selected"
                        this.errorStudent.class.guardianId = "border-red"
                    }else {
                        this.errorStudent.text.guardianId = ""
                        this.errorStudent.class.guardianId = ""
                    }

                    if(this.errorStudent.class.studentCode == "" && this.errorStudent.class.address == "" && this.errorStudent.class.phoneNumber == "" && this.errorStudent.class.email == "" && this.errorStudent.class.name == "" && this.errorStudent.class.guardianId == "") {
                        if(action == "add") {
                            $('#add-student').modal('toggle')
                            this.createStudent()
                        }

                        if(action == "edit") {
                            $('#edit-student').modal('toggle')
                            this.editStudent()
                        }
                    }
                },
                resetFormStudent() {
                    this.formStudent.name = ""
                    this.formStudent.email = ""
                    this.formStudent.phoneNumber = ""
                    this.formStudent.address = ""
                    this.formStudent.studentCode = ""
                    this.formStudent.guardianId = 0
                },
                createStudent() {
                    axios.post("add-student", this.formStudent)
                    .then(function (response) {
                        if(response.status == 200){
                            app.popUpSuccess()
                            app.resetFormStudent()
                            app.getAllStudent()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                editStudent() {
                    axios.post("edit-student", {
                        "id": app.studentSelected,
                        "name": app.formStudent.name,
                        "email": app.formStudent.email,
                        "phoneNumber": app.formStudent.phoneNumber,
                        "guardianId": app.formStudent.guardianId,
                        "studentCode": app.formStudent.studentCode,
                        "address": app.formStudent.address,
                    })
                    .then(function (response) {
                        if(response.status == 200){
                            app.popUpSuccess()
                            app.resetFormStudent()
                            app.getAllStudent()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                fillEditFormStudent(id) {
                    axios.get("{{ url('staff/find-student') }}/"+id)
                    .then(function (response) {
                        if(response.status == 200) {
                            console.log(response.data)
                            let data = response.data
                            app.formStudent.name = data.name
                            app.formStudent.studentCode = data.studentCode
                            app.formStudent.email = data.email
                            app.formStudent.phoneNumber = data.phone_number
                            app.formStudent.address = data.address
                            app.formStudent.guardianId = data.guardianId
                            app.studentSelected = data.id
                        }
                    })
                },
                confirmDeleteStudent(id) {
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
                            this.deleteStudent(id)
                        }
                    })
                },
                deleteStudent(id) {
                    axios.get("{{ url('staff/delete-student') }}/"+id)
                    .then((response) => {
                        if(response.status == 200) {
                            app.popUpSuccess()
                            app.getAllStudent()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch((error) => {
                        app.popUpError()
                    })
                }
            }
        })
    </script>
@endsection