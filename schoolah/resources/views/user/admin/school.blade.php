@extends('layouts.app-admin')

@section('css')
    <style>
        .table-margin {
            margin: 0 1em;
        }
    </style>
@endsection
@section('content')
<section class="content">
    <div id="admin">
        <div class="container" v-if="display=='school'">
            <div class="row justify-content-center display-block">
                <div class="mt-5">
                    <div class="col-md-12">
                        <h3>Manage School</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-school" @click="resetForm()">
                                <i class="fa fa-plus"></i> Add School
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
                            <th scope="col">Address</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(school, index) in schools">
                            <td>@{{ school.number }}</td>
                            <td>@{{ school.name }}</td>
                            <td>@{{ school.address }}</td>
                            <td>@{{ school.phone_number }}</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-school" @click="fillEditForm(school.id)">Edit</button>
                                <button class="btn btn-danger btn-xs" @click="confirmDeleteSchool(school.id)">Delete</button>
                                <button class="btn btn-info btn-xs" @click="goToStaff(school.id)">
                                    View Staff
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="container" v-else>
            <div class="row justify-content-center display-block">
                <div class="mt-5">
                    <div class="col-md-12">
                        <h3>Manage Staff</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-staff" @click="resetFormStaff()">
                                <i class="fa fa-plus"></i> Add Staff
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
                            <th scope="col">Phone Number</th>
                            <th scope="col">Address</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(staff, index) in selectedSchoolStaffs">
                            <td>@{{ staff.number }}</td>
                            <td>@{{ staff.name }}</td>
                            <td>@{{ staff.email }}</td>
                            <td>@{{ staff.phone_number }}</td>
                            <td>@{{ staff.address }}</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-staff" @click="fillEditFormStaff(staff.id)">Edit</button>
                                <button class="btn btn-danger btn-xs" @click="confirmDeleteStaff(staff.id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="mt-5 float-right">
                        <button class="btn btn-primary" @click="backToSchool()">
                            <i class="fa fa-arrow-left"></i> Back to school
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--modal--}}
    <div class="modal fade" id="add-school">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add School</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" :class="'form-control '+errorSchool.class.name" v-model="insertSchool.name">
                            <div class="red">@{{ errorSchool.text.name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" :class="'form-control '+errorSchool.class.phoneNumber" v-model="insertSchool.phoneNumber">
                            <div class="red">@{{ errorSchool.text.phoneNumber }}</div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea :class="'form-control '+errorSchool.class.address" cols="20" rows="3" v-model="insertSchool.address"></textarea>
                            <div class="red">@{{ errorSchool.text.address }}</div>
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

    <div class="modal fade" id="edit-school">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit School</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" :class="'form-control '+errorSchool.class.name" v-model="insertSchool.name">
                            <div class="red">@{{ errorSchool.text.name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" :class="'form-control '+errorSchool.class.phoneNumber" v-model="insertSchool.phoneNumber">
                            <div class="red">@{{ errorSchool.text.phoneNumber }}</div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea :class="'form-control '+errorSchool.class.address" cols="20" rows="3" v-model="insertSchool.address"></textarea>
                            <div class="red">@{{ errorSchool.text.address }}</div>
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

    <div class="modal fade" id="add-staff">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" :class="'form-control '+errorStaff.class.name" v-model="insertStaff.name">
                            <div class="red">@{{ errorStaff.text.name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input :class="'form-control '+errorStaff.class.email" v-model="insertStaff.email">
                            <div class="red">@{{ errorStaff.text.email }}</div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" :class="'form-control '+errorStaff.class.phoneNumber" v-model="insertStaff.phoneNumber">
                            <div class="red">@{{ errorStaff.text.phoneNumber }}</div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea :class="'form-control '+errorStaff.class.address" cols="20" rows="3" v-model="insertStaff.address"></textarea>
                            <div class="red">@{{ errorStaff.text.address }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="validateFormStaff('add')">Add</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-staff">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" :class="'form-control '+errorStaff.class.name" v-model="insertStaff.name">
                            <div class="red">@{{ errorStaff.text.name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input :class="'form-control '+errorStaff.class.email" v-model="insertStaff.email">
                            <div class="red">@{{ errorStaff.text.email }}</div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" :class="'form-control '+errorStaff.class.phoneNumber" v-model="insertStaff.phoneNumber">
                            <div class="red">@{{ errorStaff.text.phoneNumber }}</div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea :class="'form-control '+errorStaff.class.address" cols="20" rows="3" v-model="insertStaff.address"></textarea>
                            <div class="red">@{{ errorStaff.text.address }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="validateFormStaff('edit')">Edit</button>
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
                display: "school",
                insertSchool: {
                    name: "",
                    phoneNumber: "",
                    address: ""
                },
                insertStaff: {
                    name: "",
                    phoneNumber: "",
                    address: "",
                    email: "",
                },
                errorStaff: {
                    class: {
                        name: "",
                        email: "",
                        phoneNumber: "",
                        address: ""
                    },
                    text: {
                        name: "",
                        email: "",
                        phoneNumber: "",
                        address: ""
                    }

                },
                errorSchool: {
                    class: {
                        name: "",
                        phoneNumber: "",
                        address: ""
                    },
                    text: {
                        name: "",
                        phoneNumber: "",
                        address: ""
                    }
                },
                schools: {},
                selectedSchoolStaffs: {},
                selectedSchoolId: null,
                selectedStaffId: null
            },
            mounted() {
                this.getAllSchool()
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
                getAllSchool() {
                    axios.get('{{ url('admin/get-all-school') }}')
                    .then(function (response) {
                        let index = 1
                        if(response.status == 200) {
                            app.schools = response.data
                            app.schools.forEach((school) => {
                                school.number = index
                                index++
                            })
                        }
                    })
                },
                validateForm(action) {
                    if(this.required(this.insertSchool.name)) {
                        this.errorSchool.class.name = "border-red"
                        this.errorSchool.text.name = "name must be filled"
                    }else{
                        this.errorSchool.class.name = ""
                        this.errorSchool.text.name = ""
                    }

                    if(this.required(this.insertSchool.phoneNumber)) {
                        this.errorSchool.class.phoneNumber = "border-red"
                        this.errorSchool.text.phoneNumber = "phone number must be filled"
                    }else if(this.isNumber(this.insertSchool.phoneNumber)){
                        this.errorSchool.class.phoneNumber = "border-red"
                        this.errorSchool.text.phoneNumber = "phone number must be number"
                    }else {
                        this.errorSchool.class.phoneNumber = ""
                        this.errorSchool.text.phoneNumber = ""
                    }

                    if(this.required(this.insertSchool.address)) {
                        this.errorSchool.class.address = "border-red"
                        this.errorSchool.text.address = "address must be filled"
                    }else {
                        this.errorSchool.class.address = ""
                        this.errorSchool.text.address = ""
                    }

                    if(this.errorSchool.class.address == "" && this.errorSchool.class.phoneNumber  == "" && this.errorSchool.class.name == ""){
                        if(action == "add") {
                            $('#add-school').modal('toggle');
                            this.addSchool()
                        }

                        if(action == "edit") {
                            $('#edit-school').modal('toggle');
                            this.editSchool()
                        }
                    }
                },
                resetForm() {
                    app.insertSchool.name = ""
                    app.insertSchool.phoneNumber = ""
                    app.insertSchool.address = ""
                    this.resetValidateSchool()
                },
                resetValidateSchool() {
                    this.errorSchool.class.name = ""
                    this.errorSchool.class.phoneNumber = ""
                    this.errorSchool.class.address = ""
                    this.errorSchool.text.name = ""
                    this.errorSchool.text.phoneNumber = ""
                    this.errorSchool.text.address = ""
                },
                addSchool() {
                    axios.post('{{ url('admin/add-school') }}', this.insertSchool)
                    .then((response) => {
                        if (response.status == 200)  {
                            this.getAllSchool()
                            this.resetForm()
                            this.popUpSuccess()
                        }else {
                            this.popUpError()
                        }
                    })
                    .catch((error) => {
                        this.popUpError()
                    })
                },
                fillEditForm(id) {
                    axios.post('{{ url('admin/get-school/') }}', {
                        id: id
                    })
                    .then((response) => {
                        if(response.status == 200) {
                            let data = response.data
                            this.selectedSchoolId = data.id
                            this.insertSchool.name = data.name
                            this.insertSchool.phoneNumber = data.phone_number
                            this.insertSchool.address = data.address
                        }else {
                            $('#edit-school').modal('toggle');
                            this.resetForm()
                            this.popUpError()
                        }
                    })
                    .catch((error) => {
                        $('#edit-school').modal('toggle');
                        this.resetForm()
                        this.popUpError()
                    })
                },
                editSchool() {
                    axios.post('{{ url('admin/edit-school/') }}', {
                        id: app.selectedSchoolId,
                        name: app.insertSchool.name,
                        address: app.insertSchool.address,
                        phoneNumber: app.insertSchool.phoneNumber,
                    })
                    .then((response) => {
                        if(response.status == 200) {
                            this.resetForm()
                            this.popUpSuccess()
                            this.getAllSchool()
                        }else {
                            this.popUpError()
                        }
                    })
                    .catch((error) => {
                        this.popUpError()
                    })
                },
                confirmDeleteSchool(id) {
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
                            this.deleteSchool(id)
                        }
                    })
                },
                deleteSchool(id) {
                    axios.post('{{ url('admin/delete-school/') }}', {
                        id: id
                    })
                    .then((response) => {
                        if(response.status == 200) {
                            this.popUpSuccess()
                            this.getAllSchool()
                        }else {
                            this.popUpError()
                        }
                    })
                    .catch((error) => {
                        this.popUpError()
                    })
                },
                goToStaff(schoolId) {
                    this.display = 'staff'
                    this.selectedSchoolId = schoolId
                    this.getSchoolStaff()
                },
                backToSchool() {
                    this.display = 'school'
                },
                resetFormStaff() {
                    this.insertStaff.name = ""
                    this.insertStaff.phoneNumber = ""
                    this.insertStaff.address = ""
                    this.insertStaff.email = ""
                    this.resetValidateStaff()
                },
                resetValidateStaff() {
                    this.errorStaff.class.name = ""
                    this.errorStaff.class.phoneNumber = ""
                    this.errorStaff.class.address = ""
                    this.errorStaff.class.email = ""
                    this.errorStaff.text.name = ""
                    this.errorStaff.text.phoneNumber = ""
                    this.errorStaff.text.address = ""
                    this.errorStaff.text.email = ""
                },
                validateFormStaff(action) {
                    if(this.required(this.insertStaff.name)) {
                        this.errorStaff.class.name = "border-red"
                        this.errorStaff.text.name = "name must be filled"
                    }else{
                        this.errorStaff.class.name = ""
                        this.errorStaff.text.name = ""
                    }

                    if(this.required(this.insertStaff.email)) {
                        this.errorStaff.class.email = "border-red"
                        this.errorStaff.text.email = "email must be filled"
                    }else if(this.emailFormat(this.insertStaff.email)) {
                        this.errorStaff.class.email = "border-red"
                        this.errorStaff.text.email = "email must be formatted correctly"
                    }else{
                        this.errorStaff.class.email = ""
                        this.errorStaff.text.email = ""
                    }

                    if(this.required(this.insertStaff.phoneNumber)) {
                        this.errorStaff.class.phoneNumber = "border-red"
                        this.errorStaff.text.phoneNumber = "phone number must be filled"
                    }else if(this.isNumber(this.insertStaff.phoneNumber)){
                        this.errorStaff.class.phoneNumber = "border-red"
                        this.errorStaff.text.phoneNumber = "phone number must be number"
                    }else {
                        this.errorStaff.class.phoneNumber = ""
                        this.errorStaff.text.phoneNumber = ""
                    }

                    if(this.required(this.insertStaff.address)) {
                        this.errorStaff.class.address = "border-red"
                        this.errorStaff.text.address = "address must be filled"
                    }else {
                        this.errorStaff.class.address = ""
                        this.errorStaff.text.address = ""
                    }

                    if(this.errorStaff.class.address == "" && this.errorStaff.class.email  == "" && this.errorStaff.class.phoneNumber  == "" && this.errorStaff.class.name == ""){
                        if(action == "add") {
                            $('#add-staff').modal('toggle');
                            this.addStaff()
                        }

                        if(action == "edit") {
                            $('#edit-staff').modal('toggle');
                            this.editStaff()
                        }
                    }
                },
                getSchoolStaff() {
                    axios.post('{{ url('admin/get-staff') }}',{
                        school_id: this.selectedSchoolId
                    })
                    .then((response) => {
                        if(response.status == 200){
                            this.selectedSchoolStaffs = response.data
                            let index = 1
                            this.selectedSchoolStaffs.forEach((staff) => {
                                staff.number = index
                                index++
                            })
                        }else {
                            this.popUpError()
                            this.display = 'school'
                        }
                    })
                    .catch((error) => {
                        this.popUpError()
                        this.display = 'school'
                    })
                },
                addStaff() {
                    this.insertStaff.school_id = this.selectedSchoolId
                    axios.post('{{ url('admin/add-staff') }}',this.insertStaff)
                    .then((response) => {
                        if(response.status == 200) {
                            this.getSchoolStaff()
                            this.popUpSuccess()
                            this.resetFormStaff()
                        }else {
                            this.popUpError()
                        }
                    })
                    .catch((error) => {
                        this.popUpError()
                    })
                },
                fillEditFormStaff(id) {
                    axios.post('{{ url('admin/find-staff/') }}', {
                        id: id
                    })
                    .then((response) => {
                        if(response.status == 200) {
                            let data = response.data
                            this.selectedStaffId = data.id
                            this.insertStaff.name = data.name
                            this.insertStaff.phoneNumber = data.phone_number
                            this.insertStaff.address = data.address
                            this.insertStaff.email= data.email
                        }else {
                            $('#edit-staff').modal('toggle');
                            this.resetFormStaff()
                            this.popUpError()
                        }
                    })
                    .catch((error) => {
                        $('#edit-staff').modal('toggle');
                        this.resetFormStaff()
                        this.popUpError()
                    })
                },
                editStaff() {
                    axios.post('{{ url('admin/edit-staff') }}', {
                        id: app.selectedStaffId,
                        school_id: app.selectedSchoolId,
                        name: app.insertStaff.name,
                        address: app.insertStaff.address,
                        phoneNumber: app.insertStaff.phoneNumber,
                        email: app.insertStaff.email,
                    })
                    .then((response) => {
                        if(response.status == 200) {
                            this.resetFormStaff()
                            this.popUpSuccess()
                            this.getSchoolStaff()
                        }else {
                            this.popUpError()
                        }
                    })
                    .catch((error) => {
                        this.popUpError()
                    })
                },
                confirmDeleteStaff(id) {
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
                            this.deleteStaff(id)
                        }
                    })
                },
                deleteStaff(id) {
                    axios.post("{{ url('admin/delete-staff') }}", {
                        id: id
                    })
                    .then((response) => {
                        if(response.status == 200) {
                            this.popUpSuccess()
                            this.getAllTeachers()
                        }else {
                            this.popUpError()
                        }
                    })
                    .catch((error) => {
                        this.popUpError()
                    })
                }
            }
        })
    </script>
@endsection
