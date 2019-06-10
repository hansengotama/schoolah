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
                                        <button class="btn btn-info btn-xs" @click="goToTeacher(thisClass.id)">
                                            View Teacher
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
    <div v-else-if="page=='student'">
        <div id="staff">
            <div class="container">
                <div class="row justify-content-center display-block">
                    <div class="mt-5">
                        <div class="col-md-12">
                            <h3>Manage Student (@{{ selectedClass.name }})</h3>
                            <h5>Guardian Teacher: @{{ teacherName }}</h5>
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-student">
                                <i class="fa fa-plus"></i> Add Student
                            </button>
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
                            <tr v-for="(studentClass, index) in studentClasses">
                                <td>@{{ studentClass.number }}</td>
                                <td>@{{ studentClass.user.name }}</td>
                                <td>@{{ studentClass.user.email }}</td>
                                <td>@{{ studentClass.student_code }}</td>
                                <td>@{{ studentClass.user.address }}</td>
                                <td>@{{ studentClass.user.phone_number }}</td>
                                <td>
                                    <button class="btn btn-danger btn-xs" @click="confirmRemoveStudentClass(studentClass.id)">Remove</button>
                                </td>
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
    <div v-else-if="page=='teacher'">
        <div id="staff">
            <div class="container">
                <div class="row justify-content-center display-block">
                    <div class="mt-5">
                        <div class="col-md-12">
                            <h3>Manage Teacher (@{{ selectedClass.name }})</h3>
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-teacher">
                                <i class="fa fa-plus"></i> Add Teacher
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 table-margin">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Teacher Name</th>
                                <th scope="col">Teacher Code</th>
                                <th scope="col">Course</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(teacherCourse, index) in teacherCourses">
                                <td>@{{ teacherCourse.number }}</td>
                                <td>@{{ teacherCourse.teacher.name }}</td>
                                <td>@{{ teacherCourse.teacher.teacher_code }}</td>
                                <td>@{{ teacherCourse.course.name }}</td>
                                <td>
                                    <button class="btn btn-danger btn-xs" @click="confirmRemoveTeacherClass(teacherCourse.id)">Remove</button>
                                </td>
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
                                <option v-for="period in selectChoice.periods" :value=period.value>@{{ period.value }}</option>
                            </select>
                            <div class="red">@{{ error.text.period }}</div>
                        </div>
                        <div class="form-group">
                            <label>Guardian Teacher</label>
                            <select type="text" :class="'form-control '+error.class.guardianTeacherId" v-model="formValue.guardianTeacherId">
                                <option v-for="guardianTeacher in selectChoice.guardianTeachers" :value=guardianTeacher.value>@{{ guardianTeacher.guardianTeacherName }}</option>
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
                                <option v-for="period in selectChoice.periods" :value=period.value>@{{ period.value }}</option>
                            </select>
                            <div class="red">@{{ error.text.period }}</div>
                        </div>
                        <div class="form-group">
                            <label>Guardian Teacher</label>
                            <select type="text" :class="'form-control '+error.class.guardianTeacherId" v-model="formValue.guardianTeacherId">
                                <option v-for="guardianTeacher in selectChoice.guardianTeachers" :value=guardianTeacher.value>@{{ guardianTeacher.guardianTeacherName }}</option>
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
                            <label>Student Code</label>
                            <select :class="'form-control '+errorStudent.class.studentCode" v-model="formValueStudent.studentCode" @change="getStudent()">
                                <option v-for="studentCode in selectChoiceStudent.studentCodes" :value=studentCode.id>@{{ studentCode.student_code }}</option>
                            </select>
                            <div class="red">@{{ errorStudent.text.studentCode }}</div>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" :value="formValueStudent.name" disabled />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" :value="formValueStudent.email" disabled />
                        </div>
                        <div class="form-group">
                            <label>address</label>
                            <input class="form-control" :value="formValueStudent.address" disabled />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="validateFormStudent()">Add</button>
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
                            <label>Teacher Code</label>
                            <select :class="'form-control '+errorTeacher.class.teacherCode" v-model="formValueTeacher.teacherId" @change="getTeacher()">
                                <option v-for="teacherCode in selectChoiceTeacher.teacherCodes" :value=teacherCode.teacher_id>@{{ teacherCode.teacher_code }}</option>
                            </select>
                            <div class="red">@{{ errorTeacher.text.teacherCode }}</div>
                        </div>
                        <div class="form-group">
                            <label>Teacher Name</label>
                            <input class="form-control" :value="formValueTeacher.name" disabled />
                        </div>
                        <div class="form-group">
                            <label>Course</label>
                            <select :class="'form-control '+errorTeacher.class.courseName" v-model="formValueTeacher.courseId">
                                <option v-for="courseName in selectChoiceTeacher.courseNames" :value=courseName.id>@{{ courseName.name }}</option>
                            </select>
                            <div class="red">@{{ errorTeacher.text.courseName }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="validateFormTeacher()">Add</button>
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
                formValueStudent: {
                    id: "",
                    name: "",
                    studentCode: 0,
                    address: "",
                    email: ""
                },
                errorStudent: {
                    class: {
                        studentCode: ""
                    },
                    text: {
                        studentCode: ""
                    }
                },
                selectChoiceStudent: {
                    studentCodes: [{
                        student_code: "--select student code--",
                        id: 0
                    }],
                },
                formValueTeacher: {
                    name: "",
                    teacherId: 0,
                    courseId: 0
                },
                selectChoiceTeacher: {
                    teacherCodes: [{
                        teacher_code: "--select teacher code--",
                        teacher_id: 0
                    }],
                    courseNames: [{
                        name: "--select teacher code--",
                        id: 0
                    }]
                },
                errorTeacher: {
                    class: {
                        teacherCode: "",
                        courseName: ""
                    },
                    text: {
                        teacherCode: "",
                        courseName: ""
                    }
                },
                selectChoice: {
                    levels: [{
                        name: "--select level--",
                        value: 0
                    }],
                    periods: [],
                    guardianTeachers: [{
                        guardianTeacherName: "--select guardian teacher--",
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
                studentClasses: {},
                teacherName: null,
                teacherCourses: {},
                page: "class",
            },
            mounted() {
                this.getChoice()
                this.getAllClasses()
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
                    axios.get("{{ url('staff/get-period-option') }}")
                    .then(function (response) {
                        if(response.status) {
                            let data = response.data
                            app.formValue.period = data[0].value

                            for (let i=0; i<data.length; i++) {
                                app.selectChoice.periods.push(data[i])
                            }
                        }
                    })
                },
                getGuardianTeacher() {
                    this.selectChoice.guardianTeachers = [{
                        guardianTeacherName: "--select guardian teacher--",
                        value: 0
                    }]

                    axios.get('{{ url('staff/get-guardian-teacher') }}')
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
                    this.formValue.period = this.selectChoice.periods[0].value
                    this.formValue.guardianTeacherId = 0
                    this.getGuardianTeacher()
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
                    this.getGuardianTeacher()

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
                            app.selectChoice.guardianTeachers.push(response.data.select)
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
                    this.findClass(id)
                    this.getAllStudentWithoutClass()
                },
                goToTeacher(id) {
                    this.page = "teacher"
                    this.findClass(id)
                    this.getAllTeacher()
                    this.getAllCourse(id)
                    this.getTeacherCourses(id)
                },
                findClass(id) {
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
                getAllStudentClass(id) {
                    axios.get("{{ url('staff/get-student-class') }}/"+id)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.studentClasses = response.data

                            let index = 1
                            app.studentClasses.forEach((studentClass) => {
                                studentClass.number = index
                                index++
                            })
                        }
                    })
                },
                validateFormStudent() {
                    if(this.formValueStudent.studentCode == 0) {
                        this.errorStudent.text.studentCode = "student code must be selected"
                        this.errorStudent.class.studentCode = "border-red"
                    }else {
                        this.errorStudent.text.studentCode = ""
                        this.errorStudent.class.studentCode = ""
                    }

                    if(this.errorStudent.text.studentCode == "") {
                        this.addStudentClass()
                    }
                },
                resetFormStudent() {
                    this.formValueStudent.id = ""
                    this.formValueStudent.name = ""
                    this.formValueStudent.studentCode = 0
                    this.formValueStudent.address = ""
                    this.formValueStudent.email = ""
                },
                addStudentClass() {
                    axios.post("{{ url('staff/add-student-class') }}",{
                        studentId: app.formValueStudent.id,
                        classId: app.selectedClass.id
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            $('#add-student').modal('toggle');
                            app.getAllStudentWithoutClass()
                            app.resetFormStudent()
                            app.getAllStudentClass(app.selectedClass.id)
                            app.popUpSuccess()
                        } else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                confirmRemoveStudentClass(studentId) {
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
                            this.removeStudentClass(studentId)
                        }
                    })
                },
                removeStudentClass(studentId) {
                    axios.post('remove-student-class', {
                        "studentId": studentId,
                        "classId": app.selectedClass.id
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.getAllStudentWithoutClass()
                            app.getAllStudentClass(app.selectedClass.id)
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                getAllStudentWithoutClass() {
                    axios.get("get-all-student-without-class")
                    .then(function (response) {
                        if(response.status == 200) {
                            app.selectChoiceStudent.studentCodes = [{
                                student_code: "--select student code--",
                                id: 0
                            }]

                            let students = app.selectChoiceStudent.studentCodes
                            let data = response.data
                            for (let i=0; i<data.length; i++) {
                                students.push(data[i])
                            }
                        }
                    })
                },
                getStudent() {
                    axios.get("{{ url("staff/get-student") }}/"+this.formValueStudent.studentCode)
                    .then(function (response) {
                        if(response.status == 200) {
                            let data = response.data
                            app.formValueStudent.id = data.id
                            app.formValueStudent.name = data.user.name
                            app.formValueStudent.email = data.user.email
                            app.formValueStudent.address = data.user.address
                        }
                    })
                },
                getAllTeacher() {
                    axios.get("get-all-teacher")
                    .then(function (response) {
                        if(response.status == 200) {
                            app.selectChoiceTeacher.teacherCodes = [{
                                teacher_code: "--select teacher code--",
                                teacher_id: 0
                            }]

                            let teachers = app.selectChoiceTeacher.teacherCodes
                            let data = response.data
                            for (let i=0; i<data.length; i++) {
                                teachers.push(data[i])
                            }
                        }
                    })
                },
                getTeacher() {
                    axios.post("{{ url('staff/find-teacher') }}", {
                        id: this.formValueTeacher.teacherId
                    })
                    .then(function (response) {
                        if(response.success = 200) {
                            app.formValueTeacher.name = response.data.name
                        }
                    })
                },
                getAllCourse(id) {
                    axios.get("{{ url('staff/get-all-course-class') }}/"+id)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.selectChoiceTeacher.courseNames = [{
                                name: "--select teacher code--",
                                id: 0
                            }]

                            let courses = app.selectChoiceTeacher.courseNames
                            let data = response.data

                            for (let i=0; i<data.length; i++) {
                                courses.push(data[i])
                            }
                        }
                    })
                },
                validateFormTeacher() {
                    if(this.formValueTeacher.teacherId == 0) {
                        this.errorTeacher.text.teacherCode = "teacher code must be selected"
                        this.errorTeacher.class.teacherCode = "border-red"
                    }else {
                        this.errorTeacher.text.teacherCode = ""
                        this.errorTeacher.class.teacherCode = ""
                    }

                    if(this.formValueTeacher.courseId == 0) {
                        this.errorTeacher.text.courseName = "course name must be selected"
                        this.errorTeacher.class.courseName = "border-red"
                    }else {
                        this.errorTeacher.text.courseName = ""
                        this.errorTeacher.class.courseName = ""
                    }

                    if(this.errorTeacher.text.teacherCode == "" && this.errorTeacher.text.courseName == "") {
                        this.addTeacherClass()
                    }
                },
                addTeacherClass() {
                    axios.post("{{ url('staff/add-teacher-class-course') }}", {
                        teacherId: app.formValueTeacher.teacherId,
                        courseId: app.formValueTeacher.courseId,
                        classId: app.selectedClass.id
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            $('#add-teacher').modal('toggle');
                            app.popUpSuccess()
                            app.getAllCourse(app.selectedClass.id)
                            app.getTeacherCourses(app.selectedClass.id)
                            app.resetFormTeacher()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                getTeacherCourses(id) {
                    axios.get("{{ url('staff/get-teacher-class-course') }}/"+id)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.teacherCourses = response.data

                            let index = 1
                            app.teacherCourses.forEach((teacherCourse) => {
                                teacherCourse.number = index
                                index++
                            })
                        }
                    })
                },
                confirmRemoveTeacherClass(teacherCourseId) {
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
                            this.removeTeacherClass(teacherCourseId)
                        }
                    })
                },
                removeTeacherClass(teacherCourseId) {
                    axios.post("{{ url('staff/remove-teacher-class-course') }}/"+teacherCourseId)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.popUpSuccess()
                            app.getAllCourse(app.selectedClass.id)
                            app.getTeacherCourses(app.selectedClass.id)
                            app.resetFormTeacher()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                resetFormTeacher() {
                    this.formValueTeacher.name = ""
                    this.formValueTeacher.teacherId = 0
                    this.formValueTeacher.courseId = 0
                },
            }
        })
    </script>
@endsection