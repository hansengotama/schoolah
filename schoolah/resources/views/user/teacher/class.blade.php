@extends('layouts.app-admin')

@section('css')
    <style>
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
        .teacher-class-container {
            margin: 0 auto 1.5em;
            background-image: url("/img/inactive.jpeg");
            background-size: 100%;
            background-repeat: no-repeat;
            text-align: center;
            height: 250px;
            width: 250px;
            line-height: 355px;
            cursor: pointer;
            border-radius: 50%;
            position: relative;
        }
        .teacher-class-container:hover {
            background-image: url("/img/active.jpeg");
            background-size: 100%;
            background-repeat: no-repeat;
        }
        .teacher-course-container-text {
            text-transform: uppercase;
            color: white;
        }
        .teacher-class-container-text {
            text-transform: uppercase;
            color: white;
            position: absolute;
            top: 26px;
            left: 50px;
        }
        .tab-style-right {
            padding: 8px 0;
            border: 3px solid #50a9c5;
            border-top-right-radius: 16px;
            cursor: pointer;
            border-left: none;
            background-color: white;
            text-transform: uppercase;
            font-weight: 600;
        }
        .tab-style-center {
            padding: 8px 0;
            border: 3px solid #50a9c5;
            cursor: pointer;
            background-color: white;
            text-transform: uppercase;
            font-weight: 600;
        }
        .tab-style-left {
            padding: 8px 0;
            border: 3px solid #50a9c5;
            border-top-left-radius: 16px;
            border-right: none;
            cursor: pointer;
            background-color: white;
            text-transform: uppercase;
            font-weight: 600;
        }
        .activeTab {
            color: white;
            background-color: #50a9c5;
        }
        .container-details {
            border: 3px solid #4fa9c5;
            height: 500px;
            width: 100%;
            border-top: none;
            background-color: white;
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;
        }
        .btn-class {
            background-color: #4fa9c5;
            border: none;
        }
        .btn-class:hover,
        .btn-class:before,
        .btn-class:active,
        .btn-class:focus {
            background-color: #4fa9c5;
            border: none;
            color: white;
        }
        #assignment {
            margin: 30px 40px;
        }
        .btn-download {
            border: none;
            background-color: #50a9c5;
            border-radius: 5px;
            padding: 8px 12px;
            color: white;
        }
        .box-absence {
            height: 415px;
            overflow-y: auto;
        }
        .pertemuan-text {
            margin-left: 15px;
            margin-top: 15px;
        }
    </style>
@endsection

@section('content')
    <div id="class">
        <div class="ui container mt-5 mb-5" v-if="page=='class'">
            <h3 class="text-right text-uppercase title-font mb-5">
                <b>Class</b>
            </h3>
            <div class="col-md-12 p-0 mt-5 mb-5">
                <div class="row">
                    <div class="col-md-4" v-for="teacherClass in teacherClasses">
                        <div class="teacher-class-container" @click="goToClass(teacherClass.id)">
                            <div class="teacher-course-container-text">
                                <b>@{{ teacherClass.course.name }}</b>
                            </div>
                            <span class="teacher-class-container-text">
                                <div style="width: 150px">
                                    <i>@{{ teacherClass.grade.name }}</i>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui container mt-5 mb-5" v-if="page=='class-detail'">
            <h3 class="text-right text-uppercase title-font mb-5">
                <b class="float-left"><i class="fa fa-arrow-left" style="cursor: pointer; font-size: 28px" @click="backToClass()"></i></b>
                <b>@{{ selectedTeacherClass.course.name }} | @{{ selectedTeacherClass.grade.name }}</b>
            </h3>
            <div class="col-md-12 bg-white">
                <div class="row">
                    <div class="col-md-4 text-center tab-style-left" @click="changeTab('assignment')" :class="{ activeTab : tab=='assignment' }">
                        Assignment
                    </div>
                    <div class="col-md-4 text-center tab-style-center" @click="changeTab('material')" :class="{ activeTab : tab=='material' }">
                        Material
                    </div>
                    <div class="col-md-4 text-center tab-style-right" @click="changeTab('absence')" :class="{ activeTab : tab=='absence' }">
                        Absence
                    </div>
                </div>
                <div class="row" v-if="tab=='assignment'">
                    <div class="container-details">
                        <div id="assignment">
                            <button class="btn btn-primary btn-class" @click="addAssignment">
                                <i class="fa fa-plus"></i> Assignment
                            </button>
                            <table class="table table-striped table-sm mt-3">
                                <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="20%">Name</th>
                                    <th width="30%">Description</th>
                                    <th width="30%">Due Date</th>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(assignment, index) in assignments">
                                    <td style="vertical-align:middle">@{{ index+1 }}</td>
                                    <td style="vertical-align:middle">@{{ assignment.name }}</td>
                                    <td style="vertical-align:middle">@{{ assignment.description }}</td>
                                    <td style="vertical-align:middle">@{{ moment(assignment.due_date) }}</td>
                                    <td>
                                        <button class="btn-download"
                                                @click="downloadAssignment(assignment.question_file)">
                                            <i class="fa fa-download"></i>
                                        </button>
                                        <button class="btn-download"
                                                @click="viewAssignment(assignment.id)"
                                                style="background-color: #52d600">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="tab=='material'">
                    <div class="container-details">
                        <div id="assignment">
                            <button class="btn btn-primary btn-class" @click="addMaterial">
                                <i class="fa fa-plus"></i> Material
                            </button>
                            <table class="table table-striped table-sm mt-3">
                                <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="20%">Title</th>
                                    <th width="30%">Description</th>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(material, index) in materials">
                                    <td style="vertical-align:middle">@{{ index+1 }}</td>
                                    <td style="vertical-align:middle">@{{ material.title }}</td>
                                    <td style="vertical-align:middle">@{{ material.description }}</td>
                                    <td>
                                        <button class="btn-download" @click="downloadMaterial(material.file)">
                                            <i class="fa fa-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="tab=='absence'">
                    <div class="container-details">
                        <div class="container-absence" v-show="!historyAbsence">
                            <div class="col-md-12 box-absence">
                                <div class="col-md-12 p-0">
                                    <div class="pertemuan-text">
                                        <b class="float-left" style="color: #4fa9c5;">SESSION @{{ dataAttendance.session }} | DAY @{{ getDayName(dataAttendance.schedule_class.day) }} | SHIFT @{{ dataAttendance.schedule_class.order }}</b>
                                        <b class="float-right"><button class="btn btn-primary" style="background-color: #4fa9c5;padding: 2px 5px;margin-right: 15px; border: none" @click="viewHistory()">View History</button></b>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12 mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(studentClass, index) in studentClasses">
                                            <td>@{{ index+1 }}</td>
                                            <td>@{{ studentClass.student.user.name }}</td>
                                            <td>@{{ studentClass.student.student_code }}</td>
                                            <td>
                                                <select style="padding: 2px 3px; background: white;" @change="changeUserStatus(studentClass.student.id, $event)">
                                                    <option value="present">Present</option>
                                                    <option value="permit">Permit</option>
                                                    <option value="absence">Absence</option>
                                                    <option value="sick">Sick</option>
                                                </select>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div>
                                <button class="btn" style="width: 86%;margin-left: 7%; background-color: #50a9c5; color:white; border-radius: 89px;cursor: pointer;margin-top: 20px" @click="saveAbsence()">
                                    submit
                                </button>
                            </div>
                        </div>
                        <div v-show="historyAbsence">
                            <div class="col-md-12 box-absence">
                                <div class="col-md-12 p-0">
                                    <div class="pertemuan-text">
                                        <div class="col-md-12 p-0">
                                            <b class="float-right" @click="backToAbsence()">
                                                <button class="btn btn-primary" style="background-color: #4fa9c5;padding: 2px 5px;margin-right: 15px; border: none; cursor: pointer">
                                                    <i class="fa fa-arrow-left"></i> Back to absence
                                                </button>
                                            </b>
                                        </div>
                                        <div class="col-md-12" style="display: flex">
                                            <p>
                                                <b>P</b> : Permit | <b>A</b> : Absence | <b>S</b> : Sick
                                            </p>
                                        </div>
                                        <div class="col-md-12" style="display: flex">
                                            <table class="table table-striped mt-3" style="overflow: auto">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th v-for="data in totalHistoryAttendanceSession" :id="'session-'+data">@{{ data }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="dataStudent in studentClasses">
                                                        <td>@{{ dataStudent.student.user.name }}</td>
                                                        <td v-for="data in totalHistoryAttendanceSession" :id="'student-'+data+'-'+dataStudent.student_id"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-assignment">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Assignment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" :class="'form-control '+error.assignment.class.name" v-model="formData.assignment.name">
                                <div class="red">@{{ error.assignment.text.name }}</div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" :class="'form-control '+error.assignment.class.description" v-model="formData.assignment.description">
                                <div class="red">@{{ error.assignment.text.description }}</div>
                            </div>
                            <div class="form-group">
                                <label>File</label>
                                <input type="file" ref="file1" :class="'form-control '+error.assignment.class.question_file" @change="assignmentFile()">
                                <div class="red">@{{ error.assignment.text.question_file }}</div>
                            </div>
                            <div class="form-group">
                                <label>Due Date</label>
                                <input type="date" :class="'form-control '+error.assignment.class.due_date" v-model="formData.assignment.due_date" />
                                <div class="red">@{{ error.assignment.text.due_date }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="validateAssignment()">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="view-assignment">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Assignment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-sm mt-3">
                            <thead>
                            <tr>
                                <th width="10%">No</th>
                                <th width="10%">Code</th>
                                <th width="10%">Name</th>
                                <th width="20%">Created At</th>
                                <th width="20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(historyAssignment, index) in selectedHistoryAssignments">
                                <td style="vertical-align:middle">@{{ index+1 }}</td>
                                <td style="vertical-align:middle">@{{ historyAssignment.student.student_code }}</td>
                                <td style="vertical-align:middle">@{{ historyAssignment.student.user.name }}</td>
                                <td style="vertical-align:middle">@{{ moment(historyAssignment.created_at) }}</td>
                                <td>
                                    <button class="btn-download" @click="downloadHistoryAssignment(historyAssignment.answer_file)">
                                        <i class="fa fa-download"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-material">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" :class="'form-control '+error.material.class.title" v-model="formData.material.title">
                                <div class="red">@{{ error.material.text.title }}</div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" :class="'form-control '+error.material.class.description" v-model="formData.material.description">
                                <div class="red">@{{ error.material.text.description }}</div>
                            </div>
                            <div class="form-group">
                                <label>File</label>
                                <input type="file" ref="file" :class="'form-control '+error.material.class.file" @change="materialFile()">
                                <div class="red">@{{ error.material.text.file }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="validateMaterial()">Add</button>
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
                teacherClasses: {},
                selectedTeacherClass: {},
                assignments: {},
                materials: {},
                page: "class",
                tab: "assignment",
                error: {
                    assignment: {
                        class: {
                            name: "",
                            description: "",
                            question_file: "",
                            due_date: "",
                        },
                        text: {
                            name: "",
                            description: "",
                            question_file: "",
                            due_date: ""
                        }
                    },
                    material: {
                        class: {
                            file: "",
                            title: "",
                            description: ""
                        },
                        text: {
                            file: "",
                            title: "",
                            description: ""
                        }
                    }
                },
                formData: {
                    assignment: {
                        name: "",
                        description: "",
                        question_file: "",
                        due_date: moment().add(1, 'M').format('YYYY-MM-DD')
                    },
                    material: {
                        file: "",
                        title: "",
                        description: ""
                    }
                },
                selectedHistoryAssignments: [],
                studentClasses: [],
                formAbsence: [],
                dataAttendance: {
                    schedule_class: {
                        day: "",
                        order: ""
                    }
                },
                historyAbsence: false,
                historyAttendances: [],
                totalHistoryAttendanceSession: 0
            },
            mounted() {
                this.getTeacherClasses()
            },
            methods: {
                moment(date) {
                    return moment(date).format("D MMMM Y")
                },
                getDayName(value) {
                    if(value == 1) {
                        return "1 (Monday)"
                    }else if(value == 2){
                        return "2 (Tuesday)"
                    }else if(value == 3){
                        return "3 (Wednesday)"
                    }else if(value == 4){
                        return "4 (Thursday)"
                    }else if(value == 5) {
                        return "5 (Friday)"
                    }else if(value == 6) {
                        return "6 (Saturday)"
                    }else {
                        return "7 (Sunday)"
                    }
                },
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
                findInArrayOfObject(key, value, array) {
                    let response = false

                    for (var i = 0; i < array.length; i++) {
                        if (array[i][key] === value)
                            response = array[i]
                    }

                    return response
                },
                keyInArrayOfObject(key, value, array) {
                    let response = false

                    for (var i = 0; i < array.length; i++) {
                        if (array[i][key] === value)
                            response = i
                    }

                    return response
                },
                getTeacherClasses() {
                    axios.get("{{ url('teacher/get-teacher-class') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.teacherClasses = response.data
                        }
                    })
                },
                getTeacherClass() {
                    axios.get("{{ url('teacher/get-teacher-class') }}/" + this.selectedTeacherClass.id)
                    .then(function (response) {
                        if(response.status) {
                            app.selectedTeacherClass = response.data
                        }
                    })
                },
                goToClass(teacher_class_id) {
                    this.page = "class-detail"
                    this.selectedTeacherClass = this.findInArrayOfObject("id", teacher_class_id, this.teacherClasses)
                    this.getAssignments()
                    this.getMaterials()
                    this.getAllStudents()
                    this.getNextAttendance()
                    this.getHistoryAttendance()
                    this.getTotalSession()
                },
                backToClass() {
                    this.page = "class"
                },
                changeTab(tab) {
                    this.tab = tab
                },
                addAssignment() {
                    $("#add-assignment").modal("show")
                    this.resetAssignment()
                },
                addMaterial() {
                    $("#add-material").modal("show")
                    this.resetMaterial()
                },
                validateAssignment() {
                    if(this.required(this.formData.assignment.name)) {
                        this.error.assignment.text.name = "name must be required"
                        this.error.assignment.class.name = "border-red"
                    }else {
                        this.error.assignment.text.name = ""
                        this.error.assignment.class.name = ""
                    }

                    if(this.required(this.formData.assignment.description)) {
                        this.error.assignment.text.description = "description must be required"
                        this.error.assignment.class.description = "border-red"
                    }else {
                        this.error.assignment.text.description = ""
                        this.error.assignment.class.description = ""
                    }

                    if(this.required(this.formData.assignment.due_date)) {
                        this.error.assignment.text.due_date = "due date must be required"
                        this.error.assignment.class.due_date = "border-red"
                    }else if (moment(this.formData.assignment.due_date) < moment()) {
                        this.error.assignment.text.due_date = "due date cant be today or the day before"
                        this.error.assignment.class.due_date = "border-red"
                    }else {
                        this.error.assignment.text.due_date = ""
                        this.error.assignment.class.due_date = ""
                    }

                    if(this.required(this.formData.assignment.question_file)) {
                        this.error.assignment.text.question_file = "question file must be required"
                        this.error.assignment.class.question_file = "border-red"
                    }else {
                        this.error.assignment.text.question_file = ""
                        this.error.assignment.class.question_file = ""
                    }

                    if(this.error.assignment.text.name == "" &&
                        this.error.assignment.text.description == "" &&
                        this.error.assignment.text.due_date == "" &&
                        this.error.assignment.text.question_file == "") {
                        this.createAssignment()
                    }
                },
                validateMaterial() {
                    if(this.required(this.formData.material.title)) {
                        this.error.material.text.title = "title must be required"
                        this.error.material.class.title = "border-red"
                    }else {
                        this.error.material.text.title = ""
                        this.error.material.class.title = ""
                    }

                    if(this.required(this.formData.material.description)) {
                        this.error.material.text.description = "description must be required"
                        this.error.material.class.description = "border-red"
                    }else {
                        this.error.material.text.description = ""
                        this.error.material.class.description = ""
                    }

                    if(this.required(this.formData.material.file)) {
                        this.error.material.text.file = "file must be required"
                        this.error.material.class.file = "border-red"
                    }else {
                        this.error.material.text.file = ""
                        this.error.material.class.file = ""
                    }

                    if(this.error.material.text.title == "" &&
                        this.error.material.text.description == "" &&
                        this.error.material.text.file == "") {
                        this.createMaterial()
                    }
                },
                resetAssignment() {
                    this.formData.assignment.name = ""
                    this.formData.assignment.description = ""
                    this.formData.assignment.question_file = ""
                    this.formData.assignment.due_date = moment().add(1, 'M').format('YYYY-MM-DD')
                },
                createAssignment() {
                    let formData = new FormData()

                    formData.append('file', this.formData.assignment.question_file);
                    formData.set('name', this.formData.assignment.name)
                    formData.set('description', this.formData.assignment.description)
                    formData.set('due_date', this.formData.assignment.due_date)
                    formData.set('teacher_class_id', this.selectedTeacherClass.id)

                    axios.post("{{ url('teacher/add-assignment') }}", formData)
                    .then(function (response) {
                        if(response.status) {
                            app.getAssignments()
                            app.popUpSuccess()
                            app.resetAssignment()
                            $("#add-assignment").modal("hide")
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                getAssignments() {
                    axios.get("{{ url('teacher/get-assignments') }}/"+this.selectedTeacherClass.id)
                    .then(function (response) {
                        if(response.status) {
                            let baseUrl = window.location.origin
                            let assignments = response.data
                            for(let i=0; assignments.length > i; i++) {
                                assignments[i].question_file = baseUrl + '/' + assignments[i].question_file
                            }

                            app.assignments = assignments
                        }
                    })
                },
                assignmentFile() {
                    this.formData.assignment.question_file = this.$refs.file1.files[0]
                },
                materialFile() {
                    this.formData.material.file = this.$refs.file.files[0]
                },
                downloadAssignment(link) {
                    console.log(link)
                    // window.open(link, '_blank')
                },
                downloadMaterial(link) {
                    console.log(link)
                    // window.open(link, '_blank')
                },
                downloadHistoryAssignment(link) {
                    console.log(link)
                    // window.open(link, '_blank')
                },
                resetMaterial() {
                    this.formData.material.file = ""
                    this.formData.material.title = ""
                    this.formData.material.description = ""
                },
                createMaterial() {
                    let formData = new FormData()

                    formData.append('file', this.formData.material.file);
                    formData.set('title', this.formData.material.title)
                    formData.set('description', this.formData.material.description)
                    formData.set('teacher_class_id', this.selectedTeacherClass.id)

                    axios.post("{{ url('teacher/add-material') }}", formData)
                    .then(function (response) {
                        if(response.status) {
                            app.popUpSuccess()
                            app.resetMaterial()
                            app.getMaterials()
                            $("#add-material").modal("hide")
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                getMaterials() {
                    axios.get("{{ url('teacher/get-materials') }}/"+this.selectedTeacherClass.id)
                    .then(function (response) {
                        if(response.status) {
                            let baseUrl = window.location.origin
                            let materials = response.data
                            for(let i=0; materials.length > i; i++) {
                                materials[i].file = baseUrl + '/' + materials[i].file
                            }

                            app.materials = materials
                        }
                    })
                },
                viewAssignment(id) {
                    $("#view-assignment").modal("show")
                    axios.get("{{ url('teacher/get-history-assignment') }}/"+id)
                    .then(function (response) {
                        if(response.status) {
                            let baseUrl = window.location.origin
                            for(let i=0; response.data.length > i; i++) {
                                response.data[i].answer_file = baseUrl + '/' +response.data[i].answer_file
                                response.data[i].created_at = moment(response.data[i].created_at).format("D MMMM Y")
                            }
                            app.selectedHistoryAssignments = response.data
                        }
                    })
                },
                getAllStudents() {
                    let gradeId = this.selectedTeacherClass.grade.id
                    app.formAbsence = []

                    axios.get("{{ url('teacher/get-all-student') }}/"+ gradeId)
                    .then(function (response) {
                        if(response.status) {
                            app.studentClasses = response.data
                            response.data.forEach(function (data) {
                                app.formAbsence.push({
                                    "student_id": data.student.id,
                                    "status": "present"
                                });
                            })
                        }
                    })
                },
                getNextAttendance() {
                    let gradeId = app.selectedTeacherClass.grade_id
                    let courseId = app.selectedTeacherClass.course_id

                    axios.get("{{ url('teacher/get-next-attendance') }}/"+gradeId+"/"+courseId)
                    .then(function (response) {
                        if(response.status) {
                            app.dataAttendance = response.data
                        }
                    })
                },
                getHistoryAttendance() {
                    let gradeId = app.selectedTeacherClass.grade_id
                    let courseId = app.selectedTeacherClass.course_id

                    axios.get("{{ url('teacher/get-history-attendance') }}/"+gradeId+"/"+courseId)
                    .then(function (response) {
                        if(response.status) {
                            app.historyAttendances = response.data
                            app.setDataTable(response.data)
                        }
                    })
                },
                setDataTable(data) {
                    setTimeout(function(){
                        let status = "no"
                        for(let i=0; i<data.length; i++) {
                            if(data[i].status == "permit") {
                                status = "<b>P</b>"
                            }else if(data[i].status == "present") {
                                status = "<i class='fa fa-check'></i>"
                            }else if(data[i].status == "absence") {
                                status = "<b>A</b>"
                            }else if(data[i].status == "sick") {
                                status = "<b>S</b>"
                            }
                            $("#student-"+data[i].session+"-"+data[i].student_id).html(status)
                        }
                        this.$forceUpdate()
                    }, 1000);
                },
                changeUserStatus(student_id, event) {
                    let status = event.target.value
                    let studentObject = this.findInArrayOfObject("student_id", student_id, this.formAbsence)
                    studentObject.status = status
                },
                saveAbsence() {
                    Swal.fire({
                        title: 'Are you sure?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!'
                    }).then((result) => {
                        if (result.value) {
                            app.formAbsence.forEach((data) => {
                                data.schedule_class_id = app.dataAttendance.schedule_class.id
                                data.session = app.dataAttendance.session
                            })

                            axios.post("{{ url('teacher/save-absence') }}", app.formAbsence)
                            .then(function (response) {
                                if(response.status) {
                                    app.popUpSuccess()
                                    app.resetFormAbsence()
                                    app.getNextAttendance()
                                    app.getHistoryAttendance()
                                    app.getTotalSession()
                                }
                            })
                        }
                    })
                },
                resetFormAbsence() {
                    app.formAbsence.forEach((data) => {
                        data.status = "present"
                    })
                },
                viewHistory() {
                    this.historyAbsence = true
                    this.getHistoryAttendance()
                },
                backToAbsence() {
                    this.historyAbsence = false
                },
                getTotalSession() {
                    let gradeId = app.selectedTeacherClass.grade_id
                    let courseId = app.selectedTeacherClass.course_id

                    axios.get("{{ url('teacher/get-total-history-session') }}/"+gradeId+"/"+courseId)
                    .then(function (response) {
                        if(response.status) {
                            app.totalHistoryAttendanceSession = response.data
                        }
                    })
                }
            }
        })
    </script>
@endsection
