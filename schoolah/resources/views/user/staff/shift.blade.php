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
                        <h3>Manage Shift Schedule</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-shift" @click="resetForm()">
                                <i class="fa fa-plus"></i> Add Shift
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-4 table-margin">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Order</th>
                            <th scope="col">From</th>
                            <th scope="col">Until</th>
                            <th scope="col">Active from date</th>
                            <th scope="col">Active until date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(shift, index) in scheduleShifts">
                            <td>@{{ shift.number }}</td>
                            <td>@{{ shift.shift }}</td>
                            <td>@{{ shift.from }}</td>
                            <td>@{{ shift.until }}</td>
                            <td v-if="shift.active_from_date == null">Default</td>
                            <td v-else>@{{ shift.active_from_date }}</td>
                            <td v-if="shift.active_from_date == null">Default</td>
                            <td v-else>@{{ shift.active_until_date }}</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-shift" @click="fillEditForm(shift.id)">Edit</button>
                                <button class="btn btn-danger btn-xs" @click="confirmDeleteShift(shift.id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-shift">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Shift</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Order</label>
                        <input type="number" :class="'form-control '+error.class.order" min="1" v-model="formValue.order"/>
                        <div class="red">@{{ error.text.order }}</div>
                    </div>
                    <div class="form-group">
                        <label>From</label>
                        <input type="time" :class="'form-control '+error.class.from" v-model="formValue.from" />
                        <div class="red">@{{ error.text.from }}</div>
                    </div>
                    <div class="form-group">
                        <label>Until</label>
                        <input type="time" :class="'form-control '+error.class.until" v-model="formValue.until" />
                        <div class="red">@{{ error.text.until }}</div>
                    </div>
                    <span v-if="!formValue.checked">
                        <div class="form-group">
                            <label>Active From Date</label>
                            <input type="date" :class="'form-control '+error.class.activeFromDate" v-model="formValue.activeFromDate" />
                            <div class="red">@{{ error.text.activeFromDate }}</div>
                        </div>
                        <div class="form-group">
                            <label>Active Until Date</label>
                            <input type="date" :class="'form-control '+error.class.activeUntilDate" v-model="formValue.activeUntilDate" />
                            <div class="red">@{{ error.text.activeUntilDate }}</div>
                        </div>
                    </span>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" v-model="formValue.checked">
                        <label class="form-check-label">Default</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="validateForm('add')">Add</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-shift">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Shift</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Order</label>
                        <input type="number" :class="'form-control '+error.class.order" min="1" v-model="formValue.order"/>
                        <div class="red">@{{ error.text.order }}</div>
                    </div>
                    <div class="form-group">
                        <label>From</label>
                        <input type="time" :class="'form-control '+error.class.from" v-model="formValue.from" />
                        <div class="red">@{{ error.text.from }}</div>
                    </div>
                    <div class="form-group">
                        <label>Until</label>
                        <input type="time" :class="'form-control '+error.class.until" v-model="formValue.until" />
                        <div class="red">@{{ error.text.until }}</div>
                    </div>
                    <span v-if="!formValue.checked">
                        <div class="form-group">
                            <label>Active From Date</label>
                            <input type="date" :class="'form-control '+error.class.activeFromDate" v-model="formValue.activeFromDate" />
                            <div class="red">@{{ error.text.activeFromDate }}</div>
                        </div>
                        <div class="form-group">
                            <label>Active Until Date</label>
                            <input type="date" :class="'form-control '+error.class.activeUntilDate" v-model="formValue.activeUntilDate" />
                            <div class="red">@{{ error.text.activeUntilDate }}</div>
                        </div>
                    </span>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" v-model="formValue.checked">
                        <label class="form-check-label">Default</label>
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
                scheduleShifts: {},
                error: {
                    class: {
                        order: "",
                        from: "",
                        until: "",
                        activeFromDate: "",
                        activeUntilDate: "",
                        checked: ""
                    },
                    text: {
                        order: "",
                        from: "",
                        until: "",
                        activeFromDate: "",
                        activeUntilDate: "",
                        checked: ""
                    },
                },
                formValue: {
                    order: 1,
                    from: moment().format('hh:mm'),
                    until: moment().format('hh:mm'),
                    activeFromDate: moment().format('YYYY-MM-DD'),
                    activeUntilDate: moment().format('YYYY-MM-DD'),
                    checked: true
                },
                selectedScheduleShiftId: null
            },
            mounted() {
                this.getAllScheduleShift()
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
                    this.formValue.order = 1
                    this.formValue.from = moment().format('hh:mm')
                    this.formValue.until = moment().format('hh:mm')
                    this.formValue.activeFromDate = moment().format('YYYY-MM-DD')
                    this.formValue.activeUntilDate = moment().format('YYYY-MM-DD')
                    this.formValue.checked = true
                },
                validateForm(action) {
                    if(this.required(this.formValue.order)) {
                        this.error.text.order = "order must be filled"
                        this.error.class.order = "border-red"
                    }else if(this.isNumber(this.formValue.order)) {
                        this.error.text.order = "order must be number"
                        this.error.class.order = "border-red"
                    }else if(this.formValue.order <= 0) {
                        this.error.text.order = "order must more than 0"
                        this.error.class.order = "border-red"
                    } else {
                        this.error.text.order = ""
                        this.error.class.order = ""
                    }

                    if(this.formValue.from == "") {
                        this.error.text.from = "from must be filled"
                        this.error.class.from = "border-red"
                    }else {
                        this.error.text.from = ""
                        this.error.class.from = ""
                    }

                    if(this.formValue.until == "") {
                        this.error.text.until = "until must be filled"
                        this.error.class.until = "border-red"
                    }else {
                        this.error.text.until = ""
                        this.error.class.until = ""
                    }

                    if(this.formValue.checked != true) {
                        if(this.formValue.activeFromDate == "") {
                            this.error.text.activeFromDate = "active form date must be filled"
                            this.error.class.activeFromDate = "border-red"
                        }else {
                            this.error.text.activeFromDate = ""
                            this.error.class.activeFromDate = ""
                        }

                        if(this.formValue.activeUntilDate == "") {
                            this.error.text.activeUntilDate = "active until date must be filled"
                            this.error.class.activeUntilDate = "border-red"
                        }else if(moment(this.formValue.activeFromDate) > moment(this.formValue.activeUntilDate)) {
                            this.error.text.activeUntilDate = "active until date must after or same date with form date"
                            this.error.class.activeUntilDate = "border-red"
                        }else{
                            this.error.text.activeUntilDate = ""
                            this.error.class.activeUntilDate = ""
                        }
                    }else {
                        this.error.text.activeFromDate = ""
                        this.error.class.activeFromDate = ""
                        this.error.text.activeUntilDate = ""
                        this.error.class.activeUntilDate = ""
                    }

                    if(this.error.class.order == "" && this.error.class.from == "" && this.error.class.until == "" && this.error.class.activeFromDate == "" && this.error.class.activeUntilDate == "") {
                        if(action == "add") {
                            this.addScheduleShift()
                        }else if(action == "edit") {
                            this.editScheduleShift()
                        }
                    }
                },
                getAllScheduleShift() {
                    axios.get("{{ url('staff/get-all-schedule-shift') }}")
                    .then(function (response) {
                        if(response.status == 200) {
                            app.scheduleShifts = response.data

                            let index = 1
                            app.scheduleShifts.forEach((shift) => {
                                shift.number = index
                                shift.from = shift.from.replace(":00", "")
                                shift.until = shift.until.replace(":00", "")
                                if(shift.active_from_date || shift.active_until_date) {
                                    shift.active_until_date = moment(shift.active_until_date).format('DD MMM YYYY')
                                    shift.active_from_date = moment(shift.active_from_date).format('DD MMM YYYY')
                                }
                                index++
                            })
                        }
                    })
                },
                addScheduleShift() {
                    axios.post("{{ url('staff/add-schedule-shift') }}", app.formValue)
                    .then(function (response) {
                        if(response.status == 200) {
                            $('#add-shift').modal('toggle');
                            app.getAllScheduleShift()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                editScheduleShift() {
                    axios.post("{{ url('staff/edit-schedule-shift') }}", {
                        id: app.selectedScheduleShiftId,
                        order: app.formValue.order,
                        from: app.formValue.from,
                        until: app.formValue.until,
                        activeFromDate: app.formValue.activeFromDate,
                        activeUntilDate: app.formValue.activeUntilDate,
                        checked: app.formValue.checked
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            $('#edit-shift').modal('toggle');
                            app.getAllScheduleShift()
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
                    axios.post("{{ url('staff/get-schedule-shift') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.selectedScheduleShiftId = response.data.id
                            app.formValue.order = response.data.shift
                            app.formValue.from = response.data.from
                            app.formValue.until = response.data.until
                            if(response.data.active_from_date && response.data.active_until_date) {
                                app.formValue.activeFromDate = moment(response.data.active_from_date).format('YYYY-MM-DD')
                                app.formValue.activeUntilDate = moment(response.data.active_until_date).format('YYYY-MM-DD')
                                app.formValue.checked = false
                            }else {
                                app.formValue.checked = true
                            }
                        }
                    })
                    .catch(function (error) {

                    })
                },
                confirmDeleteShift(id) {
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
                            this.deleteContributorShift(id)
                        }
                    })
                },
                deleteContributorShift(id) {
                    axios.post("{{ url('staff/delete-schedule-shift') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.getAllScheduleShift()
                            app.popUpSuccess()
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