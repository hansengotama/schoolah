@extends('layouts.app-admin')

@section('css')

@endsection

@section('content')
<section class="content">
    <div v-if="page=='class'">
        <div id="staff">
            <div class="container">
                <div class="row justify-content-center display-block">
                    <div class="mt-5">
                        <div class="col-md-12">
                            <h3>Manage Class</h3>
                            <div class="font-weight-600">
                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-class" @click="resetForm()">
                                    <i class="fa fa-plus"></i> Add Class
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
                                <th scope="col">Level</th>
                                <th scope="col">Period</th>
                                <th scope="col">Guardian Teacher</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(thisClass, index) in classes">
                                    <td>@{{ thisClass.number }}</td>
                                    <td>@{{ thisClass.name }}</td>
                                    <td>@{{ thisClass.level }}</td>
                                    <td>@{{ thisClass.period }}</td>
                                    <td>@{{ thisClass.guardian_teacher }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-class" @click="fillEditForm(thisClass.id)">Edit</button>
                                        <button class="btn btn-danger btn-xs" @click="confirmDeleteClass(thisClass.id)">Delete</button>
                                        <button class="btn btn-info btn-xs" @click="goToStudent(thisClass.id)">
                                            View Student
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div id="staff">
            <div class="container">
                <div class="row justify-content-center display-block">
                    <div class="mt-5">
                        <div class="col-md-12">
                            <h3>Manage Student (@{{ selectedClass.name }})</h3>
                            <h5>Guardian Teacher: @{{ teacherName }}</h5>
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
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(student, index) in students">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <div class="mt-5 float-right">
                            <button class="btn btn-primary" @click="backToClass()">
                                <i class="fa fa-arrow-left"></i> Back to class
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-class">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Class</h5>
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
                            <label>Level</label>
                            <select type="text" :class="'form-control '+error.class.level" v-model="formValue.level">
                                <option v-for="level in selectChoice.levels" :value=level.value>@{{ level.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.level }}</div>
                        </div>
                        <div class="form-group">
                            <label>Period</label>
                            <select type="text" :class="'form-control '+error.class.period" v-model="formValue.period">
                                <option v-for="period in selectChoice.periods" :value=period.value>@{{ period.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.period }}</div>
                        </div>
                        <div class="form-group">
                            <label>Guardian Teacher</label>
                            <select type="text" :class="'form-control '+error.class.guardianTeacherId" v-model="formValue.guardianTeacherId">
                                <option v-for="guardianTeacher in selectChoice.guardianTeachers" :value=guardianTeacher.value>@{{ guardianTeacher.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.guardianTeacherId }}</div>
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
    <div class="modal fade" id="edit-class">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Class</h5>
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
                            <label>Level</label>
                            <select type="text" :class="'form-control '+error.class.level" v-model="formValue.level">
                                <option v-for="level in selectChoice.levels" :value=level.value>@{{ level.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.level }}</div>
                        </div>
                        <div class="form-group">
                            <label>Period</label>
                            <select type="text" :class="'form-control '+error.class.period" v-model="formValue.period">
                                <option v-for="period in selectChoice.periods" :value=period.value>@{{ period.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.period }}</div>
                        </div>
                        <div class="form-group">
                            <label>Guardian Teacher</label>
                            <select type="text" :class="'form-control '+error.class.guardianTeacherId" v-model="formValue.guardianTeacherId">
                                <option v-for="guardianTeacher in selectChoice.guardianTeachers" :value=guardianTeacher.value>@{{ guardianTeacher.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.guardianTeacherId }}</div>
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
                classes: {},
                formValue: {
                    name: "",
                    level: 0,
                    period: 0,
                    guardianTeacherId: 0
                },
                selectChoice: {
                    levels: [{
                        name: "--select level--",
                        value: 0
                    }],
                    periods: [{
                        name: "--select period--",
                        value: 0
                    }],
                    guardianTeachers: [{
                        name: "--select guardian teacher--",
                        value: 0
                    }]
                },
                error: {
                    text: {
                        guardianTeacherId: "",
                        name: "",
                        level: "",
                        period: ""
                    },
                    class: {
                        guardianTeacherId: "",
                        name: "",
                        level: "",
                        period: ""
                    }
                },
                selectedClassId: null,
                selectedClass: {},
                students: {},
                teacherName: null,
                page: "class",
                choiceStudentNoClass: {
                    levels: [{
                        name: "--select student--",
                        value: 0
                    }],
                }
            },
            mounted() {
                this.getChoice()
                this.getAllClasses()
                this.getAllClassWithoutClass()
            },
            methods: {
                getChoice() {
                    this.getLevelChoice()
                    this.getPeriodChoice()
                    this.getGuardianTeacher()
                },
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
                getAllClasses() {
                    axios.get('get-all-class')
                    .then(function (response) {
                        if(response.status == 200) {
                            app.classes = response.data
                            let index = 1
                            app.classes.forEach((thisClass) => {
                                thisClass.number = index
                                index++
                            })
                        }
                    })
                },
                getLevelChoice() {
                    let level = this.selectChoice.levels
                    for(let i=7; i<13; i++) {
                        level.push({
                            "name" : i,
                            "value" : i
                        })
                    }
                },
                getPeriodChoice() {
                    let period = this.selectChoice.periods
                    for(let i=2019; i<2100; i++) {
                        period.push({
                            "name" : i,
                            "value" : i
                        })
                    }
                },
                getGuardianTeacher() {
                    axios.get('get-guardian-teacher')
                    .then(function (response) {
                        if(response.status == 200) {
                            let guardianTeachers = app.selectChoice.guardianTeachers
                            let data = response.data
                            for (let i=0; i<data.length; i++) {
                                guardianTeachers.push(data[i])
                            }
                        }
                    })
                },
                validateForm(action) {
                    if(this.required(this.formValue.name)) {
                        this.error.text.name = "name must be filled"
                        this.error.class.name = "border-red"
                    }else {
                        this.error.text.name = ""
                        this.error.class.name = ""
                    }

                    if(this.formValue.level == 0) {
                        this.error.text.level = "level must be selected"
                        this.error.class.level = "border-red"
                    }else {
                        this.error.text.level = ""
                        this.error.class.level = ""
                    }

                    if(this.formValue.period == 0) {
                        this.error.text.period = "period must be selected"
                        this.error.class.period = "border-red"
                    }else {
                        this.error.text.period = ""
                        this.error.class.period = ""
                    }

                    if(this.formValue.guardianTeacherId == 0) {
                        this.error.text.guardianTeacherId = "guardian teacher must be selected"
                        this.error.class.guardianTeacherId = "border-red"
                    }else {
                        this.error.text.guardianTeacherId = ""
                        this.error.class.guardianTeacherId = ""
                    }

                    if(this.error.class.name == "" && this.error.class.level  == "" && this.error.class.period == "" && this.error.class.guardianTeacherId == ""){
                        if(action == 'add') {
                            $('#add-class').modal('toggle');
                            this.addClass()
                        }

                        if(action == 'edit') {
                            $('#edit-class').modal('toggle');
                            this.editClass()
                        }
                    }
                },
                resetForm() {
                    this.formValue.name = ""
                    this.formValue.level = 0
                    this.formValue.period = 0
                    this.formValue.guardianTeacherId = 0
                },
                addClass() {
                    axios.post('{{ url('staff/add-class') }}', app.formValue)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.popUpSuccess()
                            app.resetForm()
                            app.getAllClasses()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function () {
                        app.popUpError()
                    })
                },
                fillEditForm(id) {
                    axios.post("{{ url('staff/find-class') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.formValue.name = response.data.name
                            app.formValue.period = response.data.period
                            app.formValue.level = response.data.level
                            app.formValue.guardianTeacherId = response.data.guardian_teacher_id
                            app.selectedClassId = response.data.id
                        } else {
                            $('#edit-class').modal('toggle');
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        $('#edit-class').modal('toggle');
                        app.popUpError()
                    })
                },
                editClass() {
                    axios.post("{{ url('staff/edit-class') }}", {
                        "id": app.selectedClassId,
                        "name": app.formValue.name,
                        "level": app.formValue.level,
                        "period": app.formValue.period,
                        "guardianTeacherId": app.formValue.guardianTeacherId,
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.getAllClasses()
                            app.popUpSuccess()
                            app.resetForm()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                confirmDeleteClass(id) {
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
                            this.deleteClass(id)
                        }
                    })
                },
                deleteClass(id) {
                    axios.post("{{ url('staff/delete-class') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.getAllClasses()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                goToStudent(id) {
                    this.page = "student"
                    axios.post("{{ url('staff/find-class') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if (response.status == 200) {
                            app.selectedClass = response.data
                            app.getTeacherName(response.data.guardian_teacher_id)
                            app.getAllStudentClass(response.data.id)
                        }
                    })
                },
                getTeacherName(id) {
                    axios.post("{{ url('staff/find-teacher') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if (response.status == 200) {
                            app.teacherName = response.data.name
                        }
                    })
                },
                backToClass() {
                    this.page = "class"
                },
                getAllStudentClass() {

                },
                addStudentClass() {

                },
                getAllClassWithoutClass() {
                    axios.get("get-all-student-without-class")
                    .then(function (response) {
                        if(response.status == 200) {
                            console.log(response.data)
                        }
                    })
                }
            }
        })
    </script>
@endsection