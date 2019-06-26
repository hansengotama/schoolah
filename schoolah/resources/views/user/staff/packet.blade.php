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
        .bg-white {
            background: white;
        }
    </style>
@endsection

@section('content')
<section class="content">
    <div id="staff" v-if="page=='packet'">
        <div class="container bg-white">
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
                            <th scope="col">Level</th>
                            <th scope="col">Course Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(packet, index) in packets">
                            <td>@{{ packet.number }}</td>
                            <td>@{{ packet.name }}</td>
                            <td>@{{ packet.level }}</td>
                            <td>@{{ packet.course.name }}</td>
                            <td>@{{ packet.type }}</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-packet" @click="fillEditForm(packet.id)">Edit</button>
                                <button class="btn btn-danger btn-xs" @click="confirmDeletePacket(packet.id)">Delete</button>
                                <button class="btn btn-info btn-xs" @click="viewContributor(packet.id)">View Contributor</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="staff" v-else>
        <div class="container bg-white">
            <div class="row justify-content-center display-block">
                <div class="mt-5">
                    <div class="col-md-12">
                        <h3>Manage Teacher Contributor</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-contributor" @click="resetFormContributor()">
                                <i class="fa fa-plus"></i> Add Contributor
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
                        <tr v-for="(contributor, index) in contributors">
                            <td>@{{ contributor.number }}</td>
                            <td>@{{ contributor.name }}</td>
                            <td>
                                <button class="btn btn-danger btn-xs" @click="confirmDeleteContributor(contributor.id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="mt-5 float-right">
                        <button class="btn btn-primary" @click="backToPacket()">
                            <i class="fa fa-arrow-left"></i> Back to packet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-contributor">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Contributor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Teacher Code</label>
                            <select :class="'form-control '+errorContributor.class.teacher" v-model="formValueContributor.teacherId" @change="getTeacherNameByTeacherId()">
                                <option v-for="teacher in selectChoice.contributorTeachers" :value=teacher.id>@{{ teacher.code }}</option>
                            </select>
                            <div class="red">@{{ errorContributor.text.teacher }}</div>
                        </div>
                        <div class="form-group">
                            <label>Teacher Name</label>
                            <input type="text" class="form-control" :value="formValueContributor.teacherName" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="validateFormContributor()">Add</button>
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
                            <label>Name</label>
                            <input type="text" :class="'form-control '+error.class.name" v-model="formValue.name">
                            <div class="red">@{{ error.text.name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Total used question</label>
                            <input type="number" :class="'form-control '+error.class.totalUsedQuestion" v-model="formValue.totalUsedQuestion" min="0">
                            <div class="red">@{{ error.text.totalUsedQuestion }}</div>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select :class="'form-control '+error.class.type" v-model="formValue.type">
                                <option v-for="type in selectChoice.types" :value=type.name>@{{ type.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.type }}</div>
                        </div>
                        <div class="form-group">
                            <label>Course</label>
                            <select :class="'form-control '+error.class.course" v-model="formValue.courseId">
                                <option v-for="course in selectChoice.courses" :value=course.id>@{{ course.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.course }}</div>
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select :class="'form-control '+error.class.level" v-model="formValue.level">
                                <option v-for="level in selectChoice.levels" :value=level.value>@{{ level.value }}</option>
                            </select>
                            <div class="red">@{{ error.text.level }}</div>
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
    <div class="modal fade" id="edit-packet">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Packet</h5>
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
                            <label>Total used question</label>
                            <input type="number" :class="'form-control '+error.class.totalUsedQuestion" v-model="formValue.totalUsedQuestion" min="0">
                            <div class="red">@{{ error.text.totalUsedQuestion }}</div>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select :class="'form-control '+error.class.type" v-model="formValue.type">
                                <option v-for="type in selectChoice.types" :value=type.name>@{{ type.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.type }}</div>
                        </div>
                        <div class="form-group">
                            <label>Course</label>
                            <select :class="'form-control '+error.class.course" v-model="formValue.courseId" disabled>
                                <option v-for="course in selectChoice.courses" :value=course.id>@{{ course.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.course }}</div>
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select :class="'form-control '+error.class.level" v-model="formValue.level">
                                <option v-for="level in selectChoice.levels" :value=level.value>@{{ level.value }}</option>
                            </select>
                            <div class="red">@{{ error.text.level }}</div>
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
                page: "packet",
                packets: {},
                contributors: {},
                formValue: {
                    courseId: 0,
                    type: "--select type--",
                    totalUsedQuestion: 0,
                    name: "",
                    level: 7
                },
                formValueContributor: {
                    teacherId: 0,
                    teacherName: ""
                },
                error: {
                    text: {
                        name: "",
                        type: "",
                        course: "",
                        totalUsedQuestion: "",
                        level: "",
                    },
                    class: {
                        name: "",
                        type: "",
                        course: "",
                        totalUsedQuestion: "",
                        level: "",
                    }
                },
                errorContributor: {
                    text: {
                        teacher: ""
                    },
                    class: {
                        teacher: ""
                    }
                },
                selectChoice: {
                    types: [
                        { name: "--select type--" },
                        { name: "Quiz" },
                        { name: "Exam" }
                    ],
                    courses: [{
                        name: "--select course--",
                        id: 0
                    }],
                    contributorTeachers: [{
                        code: "--select teacher--",
                        id: 0
                    }],
                    levels: []
                },
                selectedPacket: 0,
                selectedPacketId: 0
            },
            mounted() {
                this.getSelectChoiceCourse()
                this.getSelectChoiceLevel()
                this.getAllPacket()
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
                getSelectChoiceCourse() {
                    this.selectChoice.courses = [{
                        name: "--select course--",
                        id: 0
                    }]

                    axios.get('get-all-course-for-option')
                    .then(function (response) {
                        if(response.status == 200) {
                            let courses = app.selectChoice.courses

                            let data = response.data
                            for (let i=0; i<data.length; i++) {
                                courses.push(data[i])
                            }
                        }
                    })
                },
                getSelectChoiceLevel() {
                    let levels = this.selectChoice.levels

                    for (let i = 7; i <= 12; i++) {
                        levels.push({
                            "value" : i
                        })
                    }
                },
                getSelectChoiceContributorTeacher() {
                    this.selectChoice.contributorTeachers = [{
                        code: "--select teacher--",
                        id: 0
                    }]

                    axios.get("{{ url('staff/get-all-teacher-for-option') }}/"+app.selectedPacketId)
                    .then(function (response) {
                        if(response.status == 200) {
                            let teachers = app.selectChoice.contributorTeachers

                            let data = response.data
                            for (let i=0; i<data.length; i++) {
                                teachers.push(data[i])
                            }
                        }
                    })
                },
                resetForm() {
                    this.formValue.courseId = 0
                    this.formValue.type = "--select type--"
                    this.formValue.totalUsedQuestion = 0
                    this.formValue.name = ""
                    this.formValue.level = 7
                },
                fillEditForm(id) {
                    axios.get("{{ url('staff/get-packet/') }}/"+id)
                    .then(function (response) {
                        if(response.status == 200) {
                            let data = response.data

                            app.formValue.courseId = data.course_id
                            app.formValue.totalUsedQuestion = data.total_used_question
                            app.formValue.type = data.type
                            app.formValue.name = data.name
                            app.selectedPacket = data.id
                            app.formValue.level = data.level
                        }
                    })
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
                    Swal.showLoading()
                    axios.post("{{ url('staff/delete-packet') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status = 200) {
                            app.getAllPacket()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
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

                    if(this.required(this.formValue.totalUsedQuestion)) {
                        this.error.text.totalUsedQuestion = "total used question must be filled"
                        this.error.class.totalUsedQuestion = "border-red"
                    }else if(this.isNumber(this.formValue.totalUsedQuestion)) {
                        this.error.text.totalUsedQuestion = "total used question must be number"
                        this.error.class.totalUsedQuestion = "border-red"
                    }else if(this.formValue.totalUsedQuestion <= 0) {
                        this.error.text.totalUsedQuestion = "total used question must more than 0"
                        this.error.class.totalUsedQuestion = "border-red"
                    }else {
                        this.error.text.totalUsedQuestion = ""
                        this.error.class.totalUsedQuestion = ""
                    }

                    if(this.formValue.courseId == 0) {
                        this.error.text.course = "course must be selected"
                        this.error.class.course = "border-red"
                    }else {
                        this.error.text.course = ""
                        this.error.class.course = ""
                    }

                    if(this.formValue.type == "--select type--") {
                        this.error.text.type = "type must be selected"
                        this.error.class.type = "border-red"
                    }else {
                        this.error.text.type = ""
                        this.error.class.type = ""
                    }

                    if(this.error.text.name == "" && this.error.text.totalUsedQuestion == "" && this.error.text.course == "" && this.error.text.type == "") {
                        if(action == "add") {
                            this.addPacket()
                        }else if(action == "edit") {
                            this.editPacket()
                        }
                    }
                },
                getAllPacket() {
                    axios.get("{{ url('staff/get-all-packet') }}")
                    .then(function (response) {
                        if(response.status == 200) {
                            app.packets = response.data

                            let index = 1
                            app.packets.forEach((packet) => {
                                packet.number = index
                                index++
                            })
                        }
                    })
                },
                addPacket() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/add-packet') }}", this.formValue)
                    .then(function (response) {
                        if(response.status == 200) {
                            $('#add-packet').modal('toggle');
                            app.getAllPacket()
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
                editPacket() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/edit-packet') }}", {
                        packetId: app.selectedPacket,
                        courseId: app.formValue.courseId,
                        level: app.formValue.level,
                        type: app.formValue.type,
                        name: app.formValue.name,
                        totalUsedQuestion: app.formValue.totalUsedQuestion,
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            $('#edit-packet').modal('toggle');
                            app.getAllPacket()
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
                viewContributor(packetId) {
                    this.page = "contributor"
                    this.selectedPacketId = packetId
                    this.getPacketContributor()
                    this.getSelectChoiceContributorTeacher()
                },
                validateFormContributor() {
                    if(this.formValueContributor.teacherId == 0) {
                        this.errorContributor.text.teacher = "teacher must be selected"
                        this.errorContributor.class.teacher = "border-red"
                    }else {
                        this.errorContributor.text.teacher = ""
                        this.errorContributor.class.teacher = ""
                    }

                    if(this.errorContributor.text.teacher == "") {
                        this.addPacketContributor()
                    }
                },
                getTeacherNameByTeacherId() {
                    axios.get("{{ url('staff/get-teacher-name-by-teacher-id') }}/"+ app.formValueContributor.teacherId)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.formValueContributor.teacherName = response.data
                        }else {
                            app.formValueContributor.teacherName = ""
                        }
                    })
                    .catch(function (error) {
                        app.formValueContributor.teacherName = ""
                    })
                },
                getPacketContributor() {
                    axios.get("{{ url('staff/get-packet-contributor') }}/"+app.selectedPacketId)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.contributors = response.data

                            let index = 1
                            app.contributors.forEach((contributor) => {
                                contributor.number = index
                                index++
                            })
                        }
                    })
                },
                addPacketContributor() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/add-packet-contributor') }}", {
                        teacherId: app.formValueContributor.teacherId,
                        packetId: app.selectedPacketId
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            $('#add-contributor').modal('toggle');
                            app.getSelectChoiceContributorTeacher()
                            app.getPacketContributor()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                resetFormContributor() {
                    this.formValueContributor.teacherId = 0
                    this.formValueContributor.teacherName = ""
                },
                confirmDeleteContributor(id) {
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
                            this.deleteContributor(id)
                        }
                    })
                },
                deleteContributor(id) {
                    Swal.showLoading()
                    axios.post("{{ url('staff/delete-packet-contributor') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.getPacketContributor()
                            app.getSelectChoiceContributorTeacher()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                backToPacket() {
                    this.page = "packet"
                }
            }
        })
    </script>
@endsection 