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
    <div id="staff">
        <div class="container bg-white">
            <div class="row justify-content-center display-block">
                <div class="mt-5">
                    <div class="col-md-12">
                        <h3>Manage Period</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-period" @click="resetForm()">
                                <i class="fa fa-plus"></i> Add Period
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-4 table-margin">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Period</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(period, index) in periods">
                            <td>@{{ index+1 }}</td>
                            <td>@{{ period.period }}</td>
                            <td>@{{ moment(period.start_date) }}</td>
                            <td>@{{ moment(period.end_date) }}</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-course" @click="fillEditForm(period.id)">Edit</button>
                                <button class="btn btn-danger btn-xs" @click="confirmDeletePeriod(period.id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-period">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Period</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Period</label>
                            <select type="text" :class="'form-control '+error.class.period" v-model="formValue.period">
                                <option v-for="period in selectChoice.periods" :value=period.value>@{{ period.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.period }}</div>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" :class="'form-control '+error.class.startDate" v-model="formValue.startDate">
                            <div class="red">@{{ error.text.startDate }}</div>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" :class="'form-control '+error.class.endDate" v-model="formValue.endDate">
                            <div class="red">@{{ error.text.endDate }}</div>
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
    <div class="modal fade" id="edit-period">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Period</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Period</label>
                            <select type="text" :class="'form-control '+error.class.period" v-model="formValue.period">
                                <option v-for="period in selectChoice.periods" :value=period.value>@{{ period.name }}</option>
                            </select>
                            <div class="red">@{{ error.text.period }}</div>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" :class="'form-control '+error.class.startDate" v-model="formValue.startDate">
                            <div class="red">@{{ error.text.startDate }}</div>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" :class="'form-control '+error.class.endDate" v-model="formValue.endDate">
                            <div class="red">@{{ error.text.endDate }}</div>
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
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                formValue: {
                    period: 0,
                    startDate: moment().format('YYYY-MM-DD'),
                    endDate: moment().format('YYYY-MM-DD')
                },
                error: {
                    text: {
                        period: "",
                        startDate: "",
                        endDate: ""
                    },
                    class: {
                        period: "",
                        startDate: "",
                        endDate: ""
                    }
                },
                selectChoice: {
                    periods: [{
                        name: "--select period--",
                        value: 0
                    }],
                },
                periods: {},
                selectedPeriod: 0
            },
            mounted() {
                this.getAllPeriod()
                this.getPeriodChoice()
            },
            methods: {
                moment(date) {
                    return moment(date).format("D MMMM Y")
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
                getPeriodChoice() {
                    let period = this.selectChoice.periods
                    for(let i=2019; i<2100; i++) {
                        period.push({
                            "name" : i,
                            "value" : i
                        })
                    }
                },
                validateForm(action) {
                    if(this.formValue.period == 0) {
                        this.error.text.period = "period must be selected"
                        this.error.class.period = "border-red"
                    }else {
                        this.error.text.period = ""
                        this.error.class.period = ""
                    }

                    if(this.required(this.formValue.startDate)) {
                        this.error.class.startDate = "border-red"
                        this.error.text.startDate = "start date must be required"
                    }else if(moment(this.formValue.startDate) < moment()) {
                        this.error.class.startDate = "border-red"
                        this.error.text.startDate = "start date cant be today or the day before"
                    }else {
                        this.error.class.startDate = ""
                        this.error.text.startDate = ""
                    }

                    if(this.required(this.formValue.endDate)) {
                        this.error.class.endDate = "border-red"
                        this.error.text.endDate = "end date must be required"
                    }else if(moment(this.formValue.endDate) < moment()) {
                        this.error.class.endDate = "border-red"
                        this.error.text.endDate = "end date cant be today or the day before"
                    }else if(moment(this.formValue.endDate) < moment(this.formValue.startDate)){
                        this.error.class.endDate = "border-red"
                        this.error.text.endDate = "end date must after or same date with start date"
                    }else {
                        this.error.class.endDate = ""
                        this.error.text.endDate = ""
                    }

                    if(this.error.class.period == "" &&
                        this.error.class.startDate == "" &&
                        this.error.class.endDate == "") {
                        if(action == "edit") {
                            this.editPeriod()
                        }else if(action == "add") {
                            this.createPeriod()
                        }
                    }
                },
                createPeriod() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/create-period') }}", this.formValue)
                    .then(function (response) {
                        if(response.status) {
                            app.getAllPeriod()
                            app.resetForm()
                            app.popUpSuccess()
                            $("#add-period").modal("hide")
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                getAllPeriod() {
                    axios.get("{{ url('staff/get-all-period') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.periods = response.data
                        }
                    })
                },
                editPeriod() {
                    Swal.showLoading()
                    app.formValue.periodId = app.selectedPeriod

                    axios.post("{{ url('staff/edit-period') }}", app.formValue)
                        .then(function (response) {
                            if(response.status) {
                                app.getAllPeriod()
                                app.resetForm()
                                app.popUpSuccess()
                                $("#edit-period").modal("hide")
                            }else {
                                app.popUpError()
                            }
                        })
                        .catch(function (error) {
                            app.popUpError()
                        })
                },
                fillEditForm(id) {
                    this.selectedPeriod = id
                    $("#edit-period").modal("show")

                    axios.get("{{ url('staff/get-period') }}/"+ id)
                    .then(function (response) {
                        if(response.status) {
                            let data = response.data

                            app.formValue.period = data.period
                            app.formValue.startDate = moment(data.start_date).format("YYYY-MM-DD")
                            app.formValue.endDate = moment(data.end_date).format("YYYY-MM-DD")
                        }
                    })
                },
                deletePeriod(id) {
                    Swal.showLoading()
                    axios.post("{{ url('staff/delete-period') }}", {
                        id: id
                    })
                    .then(function (response) {
                        if(response.status) {
                            app.getAllPeriod()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                confirmDeletePeriod(id) {
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
                            this.deletePeriod(id)
                        }
                    })
                },
                resetForm() {
                    this.formValue.period = 0
                    this.formValue.startDate = moment().format('YYYY-MM-DD')
                    this.formValue.endDate = moment().format('YYYY-MM-DD')
                }
            }
        })
    </script>
@endsection