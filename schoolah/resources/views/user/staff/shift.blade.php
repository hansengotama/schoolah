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
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(shift, index) in shifts">
                            <td>@{{ shift.number }}</td>
                            <td>@{{ shift.name }}</td>
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
</section>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                shifts: {},
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
                    activeFromDate: moment().format('YYYY-DD-MM'),
                    activeUntilDate: moment().format('YYYY-DD-MM'),
                    checked: true
                }
            },
            mounted() {

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
                    this.formValue.activeFromDate = moment().format('YYYY-DD-MM')
                    this.formValue.activeUntilDate = moment().format('YYYY-DD-MM')
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
                        }else {
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

                        }else if(action == "edit") {

                        }
                    }
                },
                fillEditForm(id) {

                },
                confirmDeleteShift(id) {

                }
            }
        })
    </script>
@endsection