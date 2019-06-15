@extends('layouts.app-admin')

@section('css')

@endsection

@section('content')
    <section class="content">
        <div id="staff">
            <div class="container" v-if="page=='tuition'">
                <div class="row justify-content-center display-block">
                    <div class="mt-5">
                        <div class="col-md-12">
                            <h3>Manage Tuition</h3>
                            <div class="font-weight-600">
                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-tuition" @click="resetForm()">
                                    <i class="fa fa-plus"></i> Add Tuition
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 table-margin">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Class</th>
                                <th>View Class Tuition</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(grade, index) in grades">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ grade.name }}</td>
                                <td>
                                    <button class="btn btn-info btn-xs" @click="viewTuition(grade.id)">View</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container" v-else>
                <div class="mt-4 table-margin">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Total Student</th>
                            <th>Total Paid</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="tuitionDetail in tuitionDetails">
                            <td>@{{ tuitionDetail.number }}</td>
                            <td>@{{ tuitionDetail[0].tuition.price }}</td>
                            <td>@{{ tuitionDetail[0].tuition.description }}</td>
                            <td>@{{ tuitionDetail[0].tuition.due_date }}</td>
                            <td>@{{ tuitionDetail.totalStudent }}</td>
                            <td>@{{ tuitionDetail.totalStudentPaid }}</td>
                            <td>
                                <button class="btn btn-info btn-xs" @click="detailTuition(tuitionDetail[0].tuition.id)">View</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="mt-5 float-right">
                        <button class="btn btn-primary" @click="backToTuition()">
                            <i class="fa fa-arrow-left"></i> Back to Tuition
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-tuition">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Tuition</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" :class="'form-control '+ error.class.price" v-model="formValue.price">
                            <div class="red">@{{ error.text.price }}</div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" :class="'form-control '+ error.class.description" v-model="formValue.description">
                            <div class="red">@{{ error.text.description }}</div>
                        </div>
                        <div class="form-group">
                            <label>Due Date</label>
                            <input type="date" :class="'form-control '+ error.class.dueDate" v-model="formValue.dueDate">
                            <div class="red">@{{ error.text.dueDate }}</div>
                        </div>
                        <div class="form-group">
                            <label>Class</label>
                            <select :class="'custom-select '+ error.class.grade" multiple v-model="formValue.class">
                                <option v-for="grade in grades" :value="grade.id">@{{ grade.name }}</option>
                            </select>
                            <small>press ctrl for select more than 1</small>
                            <div class="red">@{{ error.text.grade }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="validateForm()">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="tuition-detail">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tuition</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Payment Receipt</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(tuitionStudent, index) in tuitionStudents">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ tuitionStudent.student.user.name }}</td>
                                <td>@{{ tuitionStudent.status }}</td>
                                <td v-if="tuitionStudent.payment_receipt" class="text-center">
                                    <a :href="tuitionStudent.payment_receipt_url" target="_blank">
                                        <img :src="tuitionStudent.payment_receipt_url"
                                             width="150px"
                                             height="60px"
                                             style="object-fit: cover"
                                        >
                                    </a>
                                </td>
                                <td v-else class="text-center">
                                    not uploaded
                                </td>
                                <td v-if="tuitionStudent.payment_receipt">
                                    <span v-if="tuitionStudent.status == 'pending'">
                                        <button class="btn btn-info btn-xs" @click="approveTuition(tuitionStudent.id)">Approve</button>
                                        <button class="btn btn-danger btn-xs" @click="rejectTuition(tuitionStudent.id)">Reject</button>
                                    </span>
                                    <span v-else>
                                        -
                                    </span>
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
    </section>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                grades: [],
                formValue: {
                    price: 0,
                    description: "",
                    dueDate: moment().add(1, 'M').format('YYYY-MM-DD'),
                    class: [],
                },
                error: {
                    class: {
                        price: "",
                        description: "",
                        dueDate: "",
                        grade: ""
                    },
                    text: {
                        price: "",
                        description: "",
                        dueDate: "",
                        grade: ""
                    }
                },
                page: "tuition",
                selectedClassId: 0,
                selectedTuitionId: 0,
                tuitionDetails: {},
                tuitionStudents: []
            },
            mounted() {
                this.getAllClass()
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
                resetForm() {
                    this.formValue.price = 0
                    this.formValue.description = ""
                    this.formValue.dueDate = moment().add(1, 'M').format('YYYY-MM-DD')
                    this.formValue.class = []
                },
                validateForm() {
                    if (this.required(this.formValue.price)) {
                        this.error.class.price = "border-red"
                        this.error.text.price = "price must be required"
                    } else if (this.formValue.price <= 0) {
                        this.error.class.price = "border-red"
                        this.error.text.price = "price must more than equal to 0"
                    } else if (this.isNumber(this.formValue.price)) {
                        this.error.class.price = "border-red"
                        this.error.text.price = "price must be numeric"
                    } else {
                        this.error.class.price = ""
                        this.error.text.price = ""
                    }
                    
                    if (this.required(this.formValue.description)) {
                        this.error.class.description = "border-red"
                        this.error.text.description = "description must be required"
                    } else {
                        this.error.class.description = ""
                        this.error.text.description = ""
                    }

                    if (this.required(this.formValue.dueDate)) {
                        this.error.class.dueDate = "border-red"
                        this.error.text.dueDate = "due date must be required"
                    } else if (moment(this.formValue.dueDate) < moment()) {
                        this.error.class.dueDate = "border-red"
                        this.error.text.dueDate = "due date cant be today or the day before"
                    } else {
                        this.error.class.dueDate = ""
                        this.error.text.dueDate = ""
                    }

                    if (this.formValue.class.length == 0) {
                        this.error.class.grade = "border-red"
                        this.error.text.grade = "class must be selected (at least 1)"
                    } else {
                        this.error.class.grade = ""
                        this.error.text.grade = ""
                    }

                    if(this.error.class.grade == "" && this.error.class.price == "" && this.error.class.description == "" && this.error.class.dueDate == "") {
                        this.createTuition()
                    }
                },
                createTuition() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/add-tuition') }}", this.formValue)
                    .then(function (response) {
                        if(response.status) {
                            $("#add-tuition").modal("hide")
                            app.resetForm()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                },
                getAllClass() {
                    axios.get("{{ url('staff/get-all-class') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.grades = response.data
                        }else {
                            this.grades = []
                        }
                    })
                },
                viewTuition(classId) {
                    this.selectedClassId = classId
                    this.page = "tuition-detail"
                    this.getTuition()
                },
                backToTuition() {
                    this.page = "tuition"
                },
                getTuition() {
                    axios.get("{{ url('staff/get-tuition') }}/"+this.selectedClassId)
                    .then(function (response) {
                        if(response.status) {
                            app.tuitionDetails = response.data
                            let number = 1
                            Object.values(app.tuitionDetails).forEach((tuition) => {
                                tuition.totalStudent = tuition.length
                                tuition.number = number
                                let totalStudentPaid = 0

                                for(let x=0; x<tuition.length; x++) {
                                    if(tuition[x].status == "approved") {
                                        totalStudentPaid++
                                    }
                                }
                                tuition.totalStudentPaid = totalStudentPaid
                                number++
                            })
                        }
                    })
                },
                detailTuition(tuitionId) {
                    this.selectedTuitionId = tuitionId
                    this.tuitionStudents = this.tuitionDetails[this.selectedTuitionId]
                    this.tuitionStudents.forEach((tuitionStudent) => {
                        if(tuitionStudent.payment_receipt_url)
                            tuitionStudent.payment_receipt_url = tuitionStudent.payment_receipt_url.replace('public','')
                    })

                    $("#tuition-detail").modal("show")
                },
                rejectTuition(tuitionId) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, reject it!'
                    }).then((result) => {
                        if (result.value) {
                            Swal.showLoading()
                            axios.post("{{ url('staff/reject-tuition') }}", {'id' : tuitionId})
                            .then(function (response) {
                                if(response.status) {
                                    app.getTuition()
                                    $("#tuition-detail").modal("hide")
                                }
                            })
                        }
                    })
                },
                approveTuition(tuitionId) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, approve it!'
                    }).then((result) => {
                        if (result.value) {
                            Swal.showLoading()
                            axios.post("{{ url('staff/approve-tuition') }}", {'id' : tuitionId})
                            .then(function (response) {
                                if(response.status) {
                                    app.getTuition()
                                    $("#tuition-detail").modal("hide")
                                }
                            })
                        }
                    })
                }
            }
        })
    </script>
@endsection