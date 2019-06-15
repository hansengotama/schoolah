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
                        <h3>Manage Guardian</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-guardian" @click="resetForm()">
                                <i class="fa fa-plus"></i> Add Guardian
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
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(guardian, index) in guardians">
                                <td>@{{ guardian.number }}</td>
                                <td>@{{ guardian.name }}</td>
                                <td>@{{ guardian.email }}</td>
                                <td>@{{ guardian.address }}</td>
                                <td>@{{ guardian.phone_number }}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-guardian" @click="fillEditForm(guardian.id)">Edit</button>
                                    <button class="btn btn-danger btn-xs" @click="confirmDeleteGuardian(guardian.id)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-guardian">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Guardian</h5>
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
                            <label>Email</label>
                            <input type="text" :class="'form-control '+error.class.email" v-model="formValue.email">
                            <div class="red">@{{ error.text.email }}</div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" :class="'form-control '+error.class.phoneNumber" v-model="formValue.phoneNumber">
                            <div class="red">@{{ error.text.phoneNumber }}</div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea :class="'form-control '+error.class.address" cols="20" rows="3" v-model="formValue.address"></textarea>
                            <div class="red">@{{ error.text.address }}</div>
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
    <div class="modal fade" id="edit-guardian">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Guardian</h5>
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
                            <label>Email</label>
                            <input type="text" :class="'form-control '+error.class.email" v-model="formValue.email">
                            <div class="red">@{{ error.text.email }}</div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" :class="'form-control '+error.class.phoneNumber" v-model="formValue.phoneNumber">
                            <div class="red">@{{ error.text.phoneNumber }}</div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea :class="'form-control '+error.class.address" cols="20" rows="3" v-model="formValue.address"></textarea>
                            <div class="red">@{{ error.text.address }}</div>
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
                formValue: {
                    name: "",
                    email: "",
                    phoneNumber: "",
                    address: "",
                },
                error: {
                    text: {
                        name: "",
                        email: "",
                        phoneNumber: "",
                        address: "",
                    },
                    class: {
                        name: "",
                        email: "",
                        phoneNumber: "",
                        address: "",
                    }
                },
                guardians: {},
                selectedGuardianId: null
            },
            mounted() {
                this.getAllGuardian()
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
                getAllGuardian() {
                    axios.get("{{ url('staff/get-all-guardian') }}")
                    .then(function (response) {
                        if(response.status == 200) {
                            app.guardians = response.data
                            let index = 1
                            app.guardians.forEach((guardian) => {
                                guardian.number = index
                                index++
                            })
                        }
                    })
                },
                resetForm() {
                    this.formValue.name = ""
                    this.formValue.email = ""
                    this.formValue.phoneNumber = ""
                    this.formValue.address = ""
                },
                validateForm(action) {
                    if(this.required(this.formValue.name)) {
                        this.error.class.name = "border-red"
                        this.error.text.name = "name must be filled"
                    }else {
                        this.error.class.name = ""
                        this.error.text.name = ""
                    }

                    if(this.required(this.formValue.email)) {
                        this.error.class.email = "border-red"
                        this.error.text.email = "email must be filled"
                    }else if(this.emailFormat(this.formValue.email)){
                        this.error.class.email = "border-red"
                        this.error.text.email = "email must be formatted correctly"
                    }else {
                        this.error.class.email = ""
                        this.error.text.email = ""
                    }

                    if(this.required(this.formValue.phoneNumber)) {
                        this.error.class.phoneNumber = "border-red"
                        this.error.text.phoneNumber = "phone number must be filled"
                    }else if(this.isNumber(this.formValue.phoneNumber)) {
                        this.error.class.phoneNumber = "border-red"
                        this.error.text.phoneNumber = "phone number must be number"
                    }else {
                        this.error.class.phoneNumber = ""
                        this.error.text.phoneNumber = ""
                    }

                    if(this.required(this.formValue.address)) {
                        this.error.class.address = "border-red"
                        this.error.text.address = "address must be filled"
                    }else {
                        this.error.class.address = ""
                        this.error.text.address = ""
                    }

                    if(this.error.class.name == "" && this.error.class.email  == "" && this.error.class.phoneNumber  == "" && this.error.class.address == ""){
                        if(action == "add") {
                            $('#add-guardian').modal('toggle')
                            this.createGuardian()
                        }

                        if(action == "edit") {
                            $('#edit-guardian').modal('toggle')
                            this.editGuardian()
                        }
                    }
                },
                createGuardian() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/add-guardian') }}", this.formValue)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.popUpSuccess()
                            app.getAllGuardian()
                            app.resetForm()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                editGuardian() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/edit-guardian') }}", {
                        "id": app.selectedGuardianId,
                        "name": app.formValue.name,
                        "email": app.formValue.email,
                        "address": app.formValue.address,
                        "phoneNumber": app.formValue.phoneNumber,
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.popUpSuccess()
                            app.resetForm()
                            app.getAllGuardian()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                fillEditForm(id) {
                    axios.post("{{ url('staff/find-guardian') }}", {
                        "id": id
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            let data = response.data
                            app.formValue.name = data.name
                            app.formValue.email = data.email
                            app.formValue.address = data.address
                            app.formValue.phoneNumber = data.phone_number
                            app.selectedGuardianId = data.id
                        }else {
                            $('#edit-guardian').modal('toggle')
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        $('#edit-guardian').modal('toggle')
                        app.popUpError()
                    })
                },
                confirmDeleteGuardian(id) {
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
                            this.deleteGuardian(id)
                        }
                    })
                },
                deleteGuardian(id) {
                    Swal.showLoading()
                    axios.post("{{ url('staff/delete-guardian') }}", {
                        id: id
                    })
                    .then((response) => {
                        if(response.status == 200) {
                            app.getAllGuardian()
                            app.popUpSuccess()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch((error) => {
                        app.popUpError()
                    })
                }
            }
        })
    </script>
@endsection