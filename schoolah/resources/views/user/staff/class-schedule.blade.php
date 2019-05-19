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
                                    <th scope="col">Action</th>
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
        <div v-else>
            <div class="container" style="margin-top: 3em">
                <div class="col-md-12" style="padding: 0">
                    <button class="btn btn-primary" @click="backToClass()">
                        <i class="fa fa-arrow-left"></i> Back to class
                    </button>
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
                deleteButton: false
            },
            mounted() {
                this.getAllClasses()
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
                search(nameKey, myArray){
                    for (var i=0; i < myArray.length; i++) {
                        if (myArray[i].name === nameKey) {
                            return myArray[i];
                        }
                    }
                },
                getAllClasses() {
                    axios.get("{{ url('staff/get-all-class') }}")
                    .then(function (response) {
                        if(response.status == 200) {
                            app.classes = response.data
                        }
                    })
                },
                manageSchedule(classId) {
                    this.selectedClassId = classId
                    this.page = "manageSchedule"
                    this.getAllClassSchedule()
                },
                setSchedule(day, shift) {
                    this.selectedDay = day
                    this.selectedShift = shift
                    if(day == 1) {
                        this.selectedDayName = "Monday"
                    }else if(day == 2) {
                        this.selectedDayName = "Thursday"
                    }else if(day == 3) {
                        this.selectedDayName = "Wednesday"
                    }else if(day == 4) {
                        this.selectedDayName = "Tuesday"
                    }else if(day == 5) {
                        this.selectedDayName = "Friday"
                    }else if(day == 6) {
                        this.selectedDayName = "Saturday"
                    }

                    this.resetForm()
                    this.getSelectedCourse()
                    $("#add-schedule").modal("show")
                },
                getSelectedCourse() {
                    axios.get("{{ url('staff/get-selected-course') }}/"+app.selectedDay+"/"+app.selectedShift+"/"+app.selectedClassId)
                    .then(function (response) {
                        if(response.status) {
                            console.log(response.data)
                            app.selectChoiceCourse = [{
                                name: "--select course--",
                                id: 0
                            }]

                            let courses = app.selectChoiceCourse
                            let data = response.data
                            for (let i=0; i<data.length; i++) {
                                courses.push(data[i])
                            }

                            if($(".schedule-"+app.selectedDay+"-"+app.selectedShift).children("div").length) {
                                app.getCourseFromHtml()
                                app.deleteButton = true
                            }else {
                                app.deleteButton = false
                            }
                        }
                    })
                },
                getCourseFromHtml() {
                    let courseName = $(".schedule-"+this.selectedDay+"-"+this.selectedShift).children("div.coursename").text()
                    let course = this.search(courseName, this.selectChoiceCourse)

                    this.formValue.course = course.id
                },
                resetForm() {
                    this.error.text.course = ""
                    this.error.class.course = ""
                },
                validateSchedule() {
                    if(this.formValue.course == 0) {
                        this.error.text.course = "course must be selected"
                        this.error.class.course = "border-red"
                    }else {
                        this.error.text.course = ""
                        this.error.class.course = ""
                    }

                    if(this.error.text.course == "") {
                        this.addSchedule()
                    }
                },
                addSchedule() {
                    axios.post("{{ url('staff/add-schedule') }}", {
                        day: app.selectedDay,
                        shift: app.selectedShift,
                        classId: app.selectedClassId,
                        courseId: app.formValue.course
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.popUpSuccess()
                            app.getAllClassSchedule()
                            app.resetForm()
                            $("#add-schedule").modal("hide")
                        }else {
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
                        if(response.status) {
                            let data = response.data

                            for(let i = 0; i < data.length; i++) {
                                $(".schedule-"+data[i].day+"-"+data[i].order).html(function () {
                                    return "<div class='coursename'>"+data[i].course.name+"</div>" +
                                        "<div><h6>"+data[i].teacher.name+"</h6><div>"
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
                    axios.post("{{ url('staff/delete-schedule') }}", {
                        day: app.selectedDay,
                        shift: app.selectedShift,
                        classId: app.selectedClassId,
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.popUpSuccess()
                            app.getAllClassSchedule()
                            $("#add-schedule").modal("hide")
                            app.resetForm()
                            $(".schedule-"+app.selectedDay+"-"+app.selectedShift).children("div").remove()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                backToClass() {
                    this.page = "class"
                }
            }
        })
    </script>
@endsection