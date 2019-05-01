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
                        <div class="input-group">
                            <input type="number" class="form-control" min="1" v-model="formValue.order"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>From</label>
                        <div class="input-group date">
                            <input type="time" class="form-control" v-model="formValue.from" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Until</label>
                        <div class="input-group date">
                            <input type="time" class="form-control" v-model="formValue.until" />
                        </div>
                    </div>
                    <span v-if="!formValue.checked">
                        <div class="form-group">
                            <label>Active From Date</label>
                            <div class="input-group da  te">
                                <input type="date" class="form-control" v-model="formValue.activeFromDate" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Active Until Date</label>
                            <div class="input-group date">
                                <input type="date" class="form-control" v-model="formValue.activeUntilDate" />
                            </div>
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
                        form: "",
                        until: "",
                        activeFormDate: "",
                        activeUntilDate: "",
                        checked: ""
                    },
                    text: {
                        order: "",
                        form: "",
                        until: "",
                        activeFormDate: "",
                        activeUntilDate: "",
                        checked: ""
                    },
                },
                formValue: {
                    order: "",
                    form: null,
                    until: null,
                    activeFormDate: null,
                    activeUntilDate: null,
                    checked: true
                }
            },
            mounted() {
            },
            methods: {
                required(value) {
                    return (value.length < 1) ? true : false
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

                },
                validateForm(action) {
                    if(this.required(this.formValue.order)) {
                        this.error.text.order = "order must be filled"
                        this.error.class.order = "border-red"
                    }else {
                        this.error.text.order = ""
                        this.error.class.order = ""
                    }

                    // if(this.required(this.formValue.from)) {
                    //
                    // }
                    //
                    // if(this.required(this.formValue.until)) {
                    //
                    // }
                    if(this.formValue.checked != true) {
                        console.log(123123)
                        // if(this.required(this.formValue.activeFormDate)) {
                        //
                        // }
                        //
                        // if(this.required(this.formValue.activeUntilDate)) {
                        //
                        // }
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