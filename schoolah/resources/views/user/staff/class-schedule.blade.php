@extends('layouts.app-admin')

@section('css')
    <style>
        #table,
        #table > tbody > tr,
        #table > tbody > tr > td,
        #table > thead > tr > th,
        #table > thead > tr {
            border: 1px solid black;
            border-collapse: collapse;
        }
        #table {
            width: 100%;
            text-align: center;
            margin-top: 2em;
            margin-bottom: 5em;
        }
        .table-head {
            height: 50px;
        }
        .mt-2em {
            margin-top: 2em;
        }
        .coursename {
            border: 1px solid #bbe3f1;
            border-radius: 1em;
            background: #bbe3f1;
        }
        .coursename h6 {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <section>
        <div v-if="page=='class'">
            <div id="staff">
                <div class="container">
                    <div class="row justify-content-center display-block">
                        <div class="mt-5">
                            <div class="col-md-12">
                                <h3>Manage Schedule Class</h3>
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
                                    <th scope="col">Manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(thisClass, index) in classes">
                                    <td>@{{ index+1 }}</td>
                                    <td>@{{ thisClass.name }}</td>
                                    <td>@{{ thisClass.level }}</td>
                                    <td>@{{ thisClass.period }}</td>
                                    <td>@{{ thisClass.guardian_teacher }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" @click="manageSchedule(thisClass.id)">Manage</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="page=='manage'">
            <div class="container" style="margin-top: 3em">
                <div class="col-md-12" style="padding: 0">
                    <button class="btn btn-primary" @click="backToClass()">
                        <i class="fa fa-arrow-left"></i> Back to class
                    </button>
                </div>
                <div class="col-md-12 p-0 mt-5">
                    <span style="font-size: 24px">Exam</span>
                    <button class="btn btn-primary float-right" @click="addExamSchedule()">
                        <i class="fa fa-plus"></i> Exam Schedule
                    </button>
                    <div class="mt-4 table-margin">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Packet Name</th>
                                <th scope="col">Shift</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(examSchedule,index) in examSchedules">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ examSchedule.name }}</td>
                                <td>@{{ examSchedule.schedule_detail_packet.packet.name }}</td>
                                <td>@{{ examSchedule.shift }}</td>
                                <td>@{{ examSchedule.date }}</td>
                                <td>
                                    <button class="btn btn-primary" @click="fillFormExamSchedule(examSchedule.id)">Edit</button>
                                    <button class="btn btn-danger" @click="confirmRemoveExam(examSchedule.id)">Remove</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 p-0 mt-5">
                    <span style="font-size: 24px">Holiday</span>
                    <button class="btn btn-primary float-right" @click="addHolidaySchedule()">
                        <i class="fa fa-plus"></i> Holiday Schedule
                    </button>
                    <div class="mt-4 table-margin">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(holidaySchedule, index) in holidaySchedules">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ holidaySchedule.name }}</td>
                                <td>@{{ holidaySchedule.date }}</td>
                                <td>
                                    <button class="btn btn-danger" @click="confirmRemoveHoliday(holidaySchedule.id)">Remove</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <table id="table">
                    <thead>
                        <tr class="table-head">
                            <th>Shift</th>
                            <th colspan="6">Day</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-head">
                            <td>#</td>
                            <td style="width: 15.5%">Monday</td>
                            <td style="width: 15.5%">Thursday</td>
                            <td style="width: 15.5%">Wednesday</td>
                            <td style="width: 15.5%">Tuesday</td>
                            <td style="width: 15.5%">Friday</td>
                            <td style="width: 15.5%">Saturday</td>
                        </tr>
                        <tr v-for="shift in 20" style="height: 90px;">
                            <td>@{{ shift }}</td>
                            <td style="cursor: pointer" @click="setSchedule(1, shift)" :class="'schedule-1-'+shift"></td>
                            <td style="cursor: pointer" @click="setSchedule(2, shift)" :class="'schedule-2-'+shift"></td>
                            <td style="cursor: pointer" @click="setSchedule(3, shift)" :class="'schedule-3-'+shift"></td>
                            <td style="cursor: pointer" @click="setSchedule(4, shift)" :class="'schedule-4-'+shift"></td>
                            <td style="cursor: pointer" @click="setSchedule(5, shift)" :class="'schedule-5-'+shift"></td>
                            <td style="cursor: pointer" @click="setSchedule(6, shift)" :class="'schedule-6-'+shift"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="add-schedule">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div><h5 class="modal-title">Manage Schedule</h5></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div style="border-bottom: 1px solid #dee2e6">
                                <div><h6>Day: <b>@{{ selectedDayName }}</b></h6></div>
                                <div><h6>Shift: <b>@{{ selectedShift }}</b></h6></div>
                            </div>
                            <div class="form-group mt-2em">
                                <label>Select Course</label>
                                <select :class="'form-control '+error.class.course" v-model="formValue.course">
                                    <option v-for="course in selectChoiceCourse" :value=course.id>@{{ course.name }}</option>
                                </select>
                                <div class="red">@{{ error.text.course }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="validateSchedule()">Set</button>
                        <button v-if="deleteButton" type="button" class="btn btn-danger" @click="confirmationRemoveSchedule()">Remove</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-holiday-schedule">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div><h5 class="modal-title">Add Holiday Schedule</h5></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" :class="'form-control '+errorHoliday.class.name" v-model="formHoliday.name">
                                <div class="red">@{{ errorHoliday.text.name }}</div>
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" :class="'form-control '+errorHoliday.class.startDate" v-model="formHoliday.startDate">
                                <div class="red">@{{ errorHoliday.text.startDate }}</div>
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" :class="'form-control '+errorHoliday.class.endDate" v-model="formHoliday.endDate">
                                <div class="red">@{{ errorHoliday.text.endDate }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="validateHoliday()">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-exam-schedule">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div><h5 class="modal-title">Add Exam Schedule</h5></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" :class="'form-control '+errorExam.class.name" v-model="formExam.name">
                                <div class="red">@{{ errorExam.text.name }}</div>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" :class="'form-control '+errorExam.class.date" v-model="formExam.date">
                                <div class="red">@{{ errorExam.text.date }}</div>
                            </div>
                            <div class="form-group">
                                <label>Packet</label>
                                <select :class="'form-control '+errorExam.class.packet" v-model="formExam.packetId">
                                    <option v-for="packet in selectChoice.packets" :value=packet.id>@{{ packet.name }}</option>
                                </select>
                                <div class="red">@{{ errorExam.text.packet }}</div>
                            </div>
                            <div class="form-group">
                                <label>Shift</label>
                                <select :class="'form-control '+ errorExam.class.shift" v-model="formExam.shift">
                                    <option v-for="shift in selectChoice.shifts" :value="shift.value">@{{ shift.value }}</option>
                                </select>
                                <div class="red">@{{ errorExam.text.shift }}</div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" v-model="formExam.fullDay" disabled>
                                <label class="form-check-label">Full Day</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="validateExam('add')">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-exam-schedule">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div><h5 class="modal-title">Edit Exam Schedule</h5></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" :class="'form-control '+errorExam.class.name" v-model="formExam.name">
                                <div class="red">@{{ errorExam.text.name }}</div>
                            </div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" :class="'form-control '+errorExam.class.date" v-model="formExam.date">
                                <div class="red">@{{ errorExam.text.date }}</div>
                            </div>
                            <div class="form-group">
                                <label>Packet</label>
                                <select :class="'form-control '+errorExam.class.packet" v-model="formExam.packetId">
                                    <option v-for="packet in selectChoice.packets" :value=packet.id>@{{ packet.name }}</option>
                                </select>
                                <div class="red">@{{ errorExam.text.packet }}</div>
                            </div>
                            <div class="form-group">
                                <label>Shift</label>
                                <select :class="'form-control '+ errorExam.class.shift" v-model="formExam.shift">
                                    <option v-for="shift in selectChoice.shifts" :value="shift.value">@{{ shift.value }}</option>
                                </select>
                                <div class="red">@{{ errorExam.text.shift }}</div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" v-model="formExam.fullDay" disabled>
                                <label class="form-check-label">Full Day</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="validateExam('edit')">Edit</button>
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
                page: "class",
                selectedClassId: 0,
                selectedDay: 0,
                selectedShift: 0,
                selectedDayName: 0,
                formValue: {
                    course: 0
                },
                formExam: {
                    name: "",
                    shift: 1,
                    date: moment().format('YYYY-MM-DD'),
                    packetId: 0,
                    fullDay: true,
                },
                formHoliday: {
                    name: "",
                    startDate: moment().format('YYYY-MM-DD'),
                    endDate: moment().format('YYYY-MM-DD')
                },
                errorExam: {
                    text: {
                        name: "",
                        shift: "",
                        date: "",
                        packet: "",
                        fullDay: ""
                    },
                    class: {
                        name: "",
                        shift: "",
                        date: "",
                        packet: "",
                        fullDay: ""
                    }
                },
                errorHoliday: {
                    text: {
                        name: "",
                        startDate: "",
                        endDate: ""
                    },
                    class: {
                        name: "",
                        startDate: "",
                        endDate: ""
                    }
                },
                error: {
                    text: {
                        course: ""
                    },
                    class: {
                        course: ""
                    }
                },
                selectChoiceCourse: [{
                    name: "--select course--",
                    id: 0
                }],
                deleteButton: false,
                selectChoice: {
                    shifts: {},
                    packets: {},
                },
                holidaySchedules: {},
                examSchedules: {},
                selectedExamSchedule: 0
            },
            mounted() {
                this.getAllClasses()
                this.getAllPacket()
                this.getAllShift()
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
                search(nameKey, myArray) {
                    for (var i = 0; i < myArray.length; i++) {
                        if (myArray[i].name === nameKey) {
                            return myArray[i];
                        }
                    }
                },
                getAllClasses() {
                    axios.get("{{ url('staff/get-all-class') }}")
                    .then(function (response) {
                        if (response.status == 200) {
                            app.classes = response.data
                        }
                    })
                },
                manageSchedule(classId) {
                    this.selectedClassId = classId
                    this.page = "manage"
                    this.getAllClassSchedule()
                    this.getHolidaySchedules()
                    this.getExamSchedules()
                },
                setSchedule(day, shift) {
                    this.selectedDay = day
                    this.selectedShift = shift
                    if (day == 1) {
                        this.selectedDayName = "Monday"
                    } else if (day == 2) {
                        this.selectedDayName = "Thursday"
                    } else if (day == 3) {
                        this.selectedDayName = "Wednesday"
                    } else if (day == 4) {
                        this.selectedDayName = "Tuesday"
                    } else if (day == 5) {
                        this.selectedDayName = "Friday"
                    } else if (day == 6) {
                        this.selectedDayName = "Saturday"
                    }

                    this.resetForm()
                    this.getSelectedCourse()
                    $("#add-schedule").modal("show")
                },
                getSelectedCourse() {
                    axios.get("{{ url('staff/get-selected-course') }}/" + app.selectedDay + "/" + app.selectedShift + "/" + app.selectedClassId)
                    .then(function (response) {
                        if (response.status) {
                            app.selectChoiceCourse = [{
                                name: "--select course--",
                                id: 0
                            }]

                            let courses = app.selectChoiceCourse
                            let data = response.data
                            for (let i = 0; i < data.length; i++) {
                                courses.push(data[i])
                            }

                            if ($(".schedule-" + app.selectedDay + "-" + app.selectedShift).children("div").length) {
                                app.getCourseFromHtml()
                                app.deleteButton = true
                            } else {
                                app.deleteButton = false
                            }
                        }
                    })
                },
                getCourseFromHtml() {
                    let courseName = $(".schedule-" + this.selectedDay + "-" + this.selectedShift).children("div.coursename").text()
                    let course = this.search(courseName, this.selectChoiceCourse)

                    this.formValue.course = course.id
                },
                resetForm() {
                    this.error.text.course = ""
                    this.error.class.course = ""
                },
                validateSchedule() {
                    if (this.formValue.course == 0) {
                        this.error.text.course = "course must be selected"
                        this.error.class.course = "border-red"
                    } else {
                        this.error.text.course = ""
                        this.error.class.course = ""
                    }

                    if (this.error.text.course == "") {
                        this.addSchedule()
                    }
                },
                addSchedule() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/add-schedule') }}", {
                        day: app.selectedDay,
                        shift: app.selectedShift,
                        classId: app.selectedClassId,
                        courseId: app.formValue.course
                    })
                    .then(function (response) {
                        if (response.status) {
                            app.popUpSuccess()
                            app.getAllClassSchedule()
                            app.resetForm()
                            $("#add-schedule").modal("hide")
                        } else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                getAllClassSchedule() {
                    axios.get("{{ url('staff/get-all-class-schedule') }}/" + app.selectedClassId)
                        .then(function (response) {
                            if (response.status) {
                                let data = response.data

                                for (let i = 0; i < data.length; i++) {
                                    $(".schedule-" + data[i].day + "-" + data[i].order).html(function () {
                                        return "<div class='coursename' style='margin: 0 2em'><h6>" + data[i].course.name + "</h6></div>" +
                                            "<div style='margin: 0 2em'><h6>" + data[i].teacher.name + "</h6><div>"
                                    })
                                }
                            }
                        })
                },
                confirmationRemoveSchedule() {
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
                            this.removeSchedule()
                        }
                    })
                },
                removeSchedule() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/delete-schedule') }}", {
                        day: app.selectedDay,
                        shift: app.selectedShift,
                        classId: app.selectedClassId,
                    })
                    .then(function (response) {
                        if (response.status) {
                            app.popUpSuccess()
                            app.getAllClassSchedule()
                            $("#add-schedule").modal("hide")
                            app.resetForm()
                            $(".schedule-" + app.selectedDay + "-" + app.selectedShift).children("div").remove()
                        } else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                backToClass() {
                    this.page = "class"
                },
                addHolidaySchedule() {
                    $("#add-holiday-schedule").modal("show")
                    this.resetHolidayForm()
                },
                addExamSchedule() {
                    $("#add-exam-schedule").modal("show")
                    this.resetExamForm()
                },
                validateHoliday() {
                    if(this.required(this.formHoliday.name)) {
                        this.errorHoliday.class.name = "border-red"
                        this.errorHoliday.text.name = "name must be required"
                    } else {
                        this.errorHoliday.class.name = ""
                        this.errorHoliday.text.name = ""
                    }

                    if(this.required(this.formHoliday.startDate)) {
                        this.errorHoliday.class.startDate = "border-red"
                        this.errorHoliday.text.startDate = "start date must be required"
                    }else if (moment(this.formHoliday.startDate) < moment()) {
                        this.errorHoliday.class.startDate = "border-red"
                        this.errorHoliday.text.startDate = "start date cant be today or the day before"
                    }else {
                        this.errorHoliday.class.startDate = ""
                        this.errorHoliday.text.startDate = ""
                    }

                    if(this.required(this.formHoliday.endDate)) {
                        this.errorHoliday.class.endDate = "border-red"
                        this.errorHoliday.text.endDate = "end date must be required"
                    }else if (moment(this.formHoliday.endDate) < moment()) {
                        this.errorHoliday.class.endDate = "border-red"
                        this.errorHoliday.text.endDate = "end date cant be today or the day before"
                    }else if (moment(this.formHoliday.endDate) < moment(this.formHoliday.startDate)) {
                        this.errorHoliday.class.endDate = "border-red"
                        this.errorHoliday.text.endDate = "end date must after or same date with start date"
                    }else {
                        this.errorHoliday.class.endDate = ""
                        this.errorHoliday.text.endDate = ""
                    }

                    if(this.errorHoliday.class.name == "" &&
                        this.errorHoliday.class.startDate == "" &&
                        this.errorHoliday.class.endDate == "") {
                        this.createHoliday()
                    }
                },
                createHoliday() {
                    Swal.showLoading()
                    app.formHoliday.classId = app.selectedClassId
                    axios.post("{{  url('staff/create-schedule-holiday') }}", this.formHoliday)
                        .then(function (response) {
                            if(response.status) {
                                $("#add-holiday-schedule").modal("hide")
                                app.resetHolidayForm()
                                app.popUpSuccess()
                                app.getHolidaySchedules()
                            }else {
                                app.popUpError()
                            }
                        })
                        .catch(function (error) {
                            app.popUpError()
                        })
                },
                resetHolidayForm() {
                    this.formHoliday.name = ""
                    this.formHoliday.startDate = moment().format('YYYY-MM-DD')
                    this.formHoliday.endDate = moment().format('YYYY-MM-DD')
                },
                getHolidaySchedules() {
                    axios.get("{{ url('staff/get-holiday-schedules') }}/"+this.selectedClassId)
                    .then(function (response) {
                        if(response.status) {
                            app.holidaySchedules = response.data
                        }
                    })
                },
                confirmRemoveHoliday(id) {
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
                            this.removeHoliday(id)
                        }
                    })
                },
                removeHoliday(id) {
                    Swal.showLoading()
                    axios.post("{{ url('staff/remove-holiday-schedule') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.popUpSuccess()
                            app.getHolidaySchedules()
                        } else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                getAllPacket() {
                    this.selectChoice.packets = [{
                        name: "--select packet--",
                        id: 0
                    }]

                    axios.get("{{ url('staff/get-all-exam-packet') }}")
                    .then(function (response) {
                        if(response.status) {
                            let packets = app.selectChoice.packets

                            let data = response.data
                            for (let i=0; i<data.length; i++) {
                                packets.push(data[i])
                            }
                        }
                    })
                },
                getAllShift() {
                    let shifts = this.selectChoice.shifts
                    shifts = [{
                        value: 1
                    }]

                    for (let i=2; i<19; i++) {
                        shifts.push({value: i})
                    }
                    this.selectChoice.shifts = shifts
                },
                validateExam(action) {
                    if(this.required(this.formExam.name)) {
                        this.errorExam.text.name = "name must be required"
                        this.errorExam.class.name = "border-red"
                    }else {
                        this.errorExam.text.name = ""
                        this.errorExam.class.name = ""
                    }

                    if(this.formExam.shift == 0) {
                        this.errorExam.text.shift = "shift must be selected"
                        this.errorExam.class.shift = "border-red"
                    }else {
                        this.errorExam.text.shift = ""
                        this.errorExam.class.shift = ""
                    }

                    if(this.required(this.formExam.date)) {
                        this.errorExam.text.date = "date must be required"
                        this.errorExam.class.date = "border-red"
                    }else if(moment(this.formExam.date) < moment()) {
                        this.errorExam.text.date = "date must cant be today or the day before"
                        this.errorExam.class.date = "border-red"
                    }else {
                        this.errorExam.text.date = ""
                        this.errorExam.class.date = ""
                    }

                    if(this.formExam.packetId == 0) {
                        this.errorExam.text.packet = "packet must be selected"
                        this.errorExam.class.packet = "border-red"
                    }else {
                        this.errorExam.text.packet = ""
                        this.errorExam.class.packet = ""
                    }


                    if(this.errorExam.class.name == "" &&
                        this.errorExam.class.shift == "" &&
                        this.errorExam.class.date == "" &&
                        this.errorExam.class.packet == "") {
                        if(action == "edit") {
                            this.editExam()
                        }else if(action == "add") {
                            this.createExam()
                        }
                    }
                },
                createExam() {
                    Swal.showLoading()
                    app.formExam.classId = app.selectedClassId
                    axios.post("{{ url('staff/create-schedule-exam') }}", this.formExam)
                    .then(function (response) {
                        if(response.status) {
                            app.resetExamForm()
                            $("#add-exam-schedule").modal("hide")
                            app.popUpSuccess()
                            app.getExamSchedules()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                resetExamForm() {
                    this.formExam.name = ""
                    this.formExam.shift = 1
                    this.formExam.date = moment().format('YYYY-MM-DD')
                    this.formExam.packetId = 0
                    this.formExam.fullDay = true
                },
                getExamSchedules() {
                    axios.get("{{ url('staff/get-exam-schedules') }}/"+this.selectedClassId)
                    .then(function (response) {
                        if(response.status) {
                            app.examSchedules = response.data
                        }
                    })
                },
                confirmRemoveExam(id) {
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
                            this.removeExam(id)
                        }
                    })
                },
                removeExam(id) {
                    Swal.showLoading()
                    axios.post("{{ url('staff/remove-exam-schedule') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.popUpSuccess()
                            app.getExamSchedules()
                        } else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                fillFormExamSchedule(id) {
                    this.selectedExamSchedule = id

                    axios.get("{{ url('staff/get-exam-schedule') }}/"+id)
                    .then(function (response) {
                        if(response.status) {
                            let data = response.data

                            app.formExam.packetId = data.schedule_detail_packet.packet_id
                            app.formExam.date = moment(data.date).format('YYYY-MM-DD')
                            app.formExam.name = data.name
                            app.formExam.shift = data.shift
                            $("#edit-exam-schedule").modal("show")
                        }else {
                            app.popUpError()
                        }
                    })
                },
                editExam() {
                    Swal.showLoading()
                    app.formExam.classId = app.selectedClassId
                    app.formExam.scheduleDetailId = app.selectedExamSchedule

                    axios.post("{{ url('staff/edit-exam-schedule') }}", app.formExam)
                    .then(function (response) {
                        if(response.status) {
                            app.resetExamForm()
                            $("#edit-exam-schedule").modal("hide")
                            app.popUpSuccess()
                            app.getExamSchedules()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                }
            }
        })
    </script>
@endsection