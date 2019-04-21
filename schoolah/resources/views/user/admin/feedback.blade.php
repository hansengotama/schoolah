@extends('layouts.app-admin')

@section('css')

@endsection

@section('content')
<section class="content">
    <div id="staff">
        <div class="container">
            <div class="row justify-content-center display-block">
                <div class="mt-4 table-margin">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                            <th scope="col">Feedback</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="thisFeedback in feedback">
                                <td>@{{ thisFeedback.number }}</td>
                                <td>@{{ thisFeedback.name }}</td>
                                <td>@{{ thisFeedback.role }}</td>
                                <td>@{{ thisFeedback.feedback }}</td>
                                <td>
                                    <button class="btn btn-danger btn-xs" @click="confirmDeleteFeedback(thisFeedback.id)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                feedback: {}
            },
            mounted() {
                this.getAllFeedback()
            },
            methods: {
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
                getAllFeedback() {
                    axios.get("{{ url('admin/get-all-feedback') }}")
                    .then(function (response) {
                        if(response.status == 200) {
                            app.feedback = response.data
                            let index = 1
                            app.feedback.forEach((thisFeedback) => {
                                thisFeedback.number = index
                                index++
                            })
                        }
                    })
                },
                confirmDeleteFeedback(id) {
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
                            this.deleteFeedback(id)
                        }
                    })
                },
                deleteFeedback(id) {
                    axios.post("{{ url('admin/delete-feedback') }}", {
                        id: id
                    })
                    .then((response) => {
                        if(response.status == 200) {
                            app.getAllFeedback()
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