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
    <div id="staff">
        <div class="container bg-white">
            <div class="row justify-content-center display-block">
                <div class="mt-5">
                    <div class="col-md-12">
                        <h3>Manage Course</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-course" @click="resetForm()">
                                <i class="fa fa-plus"></i> Add Course
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
                        <tr v-for="(course, index) in courses">
                            <td>@{{ course.number }}</td>
                            <td>@{{ course.name }}</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-course" @click="fillEditForm(course.id)">Edit</button>
                                <button class="btn btn-danger btn-xs" @click="confirmDeleteCourse(course.id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-course">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Course</h5>
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
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="validateForm('add')">Add</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-course">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Course</h5>
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
                    name: ""
                },
                error: {
                    text: {
                        name: ""
                    },
                    class: {
                        name: ""
                    }
                },
                courses: {},
                selectedCourse: null
            },
            mounted() {
                this.getAllCourse()
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
                    this.formValue.name = ""
                },
                fillEditForm(id) {
                    axios.get('{{ url('staff/find-course') }}/'+id)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.formValue.name = response.data.name
                            app.selectedCourse = response.data.id
                        }
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

                    if(this.error.class.name == "") {
                        if(action == "edit") {
                            $('#edit-course').modal('toggle')
                            this.editCourse()
                        }

                        if(action == "add") {
                            $('#add-course').modal('toggle')
                            this.addCourse()
                        }
                    }
                },
                addCourse() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/add-course') }}", app.formValue)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.courses = response.data
                            app.getAllCourse()
                            app.popUpSuccess()
                            app.resetForm()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                editCourse() {
                    Swal.showLoading()
                    axios.post("{{ url('staff/edit-course') }}",{
                        "id": app.selectedCourse,
                        "name": app.formValue.name
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.courses = response.data
                            app.getAllCourse()
                            app.popUpSuccess()
                            app.resetForm()
                        }else {
                            app.popUpError()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                    })
                },
                getAllCourse() {
                    axios.get("{{ url('staff/get-all-course') }}")
                    .then(function (response) {
                        if(response.status == 200) {
                            let index = 1
                            app.courses = response.data
                            app.courses.forEach((course) => {
                                course.number = index
                                index++
                            })
                        }
                    })
                },
                confirmDeleteCourse(id) {
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
                            this.deleteCourse(id)
                        }
                    })
                },
                deleteCourse(id) {
                    Swal.showLoading()
                    axios.post("{{ url('staff/delete-course') }}",{
                        "id": id,
                    })
                    .then(function (response) {
                        if(response.status == 200) {
                            app.getAllCourse()
                            app.popUpSuccess()
                            app.resetForm()
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