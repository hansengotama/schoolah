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
                        <h3>Manage Student</h3>
                        <div class="font-weight-600">
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-student" @click="resetForm()">
                                <i class="fa fa-plus"></i> Add Student
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
{{--                        <tr v-for="(school, index) in schools">--}}
{{--                            <td>@{{ school.number }}</td>--}}
{{--                            <td>@{{ school.name }}</td>--}}
{{--                            <td>@{{ school.address }}</td>--}}
{{--                            <td>@{{ school.phone_number }}</td>--}}
{{--                            <td>--}}
{{--                                <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit-school" @click="fillEditForm(school.id)">Edit</button>--}}
{{--                                <button class="btn btn-danger btn-xs" @click="confirmDeleteSchool(school.id)">Delete</button>--}}
{{--                                <button class="btn btn-info btn-xs" @click="goToStaff(school.id)">--}}
{{--                                    View Staff--}}
{{--                                </button>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-student">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Student</h5>
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
</section>
@endsection

@section('js')

@endsection