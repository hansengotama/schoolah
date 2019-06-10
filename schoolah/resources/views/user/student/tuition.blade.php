@extends('layouts.app-admin')

@section('css')
@endsection
<style>
    .title-font {
        border-bottom: 6px solid #51a9c5;
        padding-bottom: 6px;
        font-size: 50px;
        color: #51a9c5;
    }
    .bg-unpaid {
        background-color: #ffe4f0;
    }
    .btn-upload {
        border: none;
        background-color: #50a9c5;
        border-radius: 5px;
        padding: 8px 12px;
    }
    .upload-picture {
        border: 6px dashed #c3c3c3;
        padding: 6em;
        border-radius: 10px;
        text-align: center;
        color: #c3c3c3;
        cursor: pointer;
    }
    .w-80 {
        width: 80%;
    }
    .image-upload {
        width:80% !important;
        height:267px !important;
        cursor: pointer;
    }

    .crop img {
        display: block;
        width: 100vw;
        height: 100vh;
        object-fit: cover;
        margin: 0 auto;
    }
    td {
        vertical-align: middle !important;
    }
</style>

@section('content')
    <div id="quiz">
        <div class="container mt-5">
            <h3 class="text-right text-uppercase title-font">
                <b>Tuition</b>
            </h3>
            <div class="col-md-12" style="margin-top: 5em">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table ">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(tuition, index) in tuitions" :class="{'bg-unpaid': tuition.status=='unpaid'}">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ tuition.tuition_price }}</td>
                                <td>@{{ tuition.tuition_description }}</td>
                                <td>@{{ tuition.due_date }}</td>
                                <td>@{{ tuition.status }}</td>
                                <td>
                                    <button class="btn-upload" @click="showDetailModal(tuition.tuiton_history_id)">
                                        <i class="fa fa-upload" style="color: white;"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="detail-modal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tuition Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <label for="upload" class="w-80">
                                <div v-if="image" class="crop">
                                    <img :src="image" class="image-upload">
                                    <input type="file" id="upload" accept="image/*" @change="onFileChange" hidden>
                                </div>
                                <div class="upload-picture" v-else>
                                    <i class="fa fa-upload" style="font-size: 4rem"></i>
                                    <input type="file" id="upload" accept="image/*" @change="onFileChange" hidden>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" :disabled="!canSave" @click="saveImage()"><i class="fa fa-save"></i> Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
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
                tuitions: {},
                image: null,
                imageNotBase64: null,
                canSave: false,
                selectedTuition: {}
            },
            mounted() {
                this.getTuitions()
            },
            methods: {
                getTuitions() {
                    axios.get("{{ url('student/get-tuitions') }}")
                    .then(function (response) {
                        if(response.status) {
                            app.tuitions = response.data
                        }
                    })
                },
                showDetailModal(id) {
                    axios.get("{{ url('student/get-history-detail') }}/"+id)
                    .then(function (response) {
                        if(response.status) {
                            app.selectedTuition = response.data
                            $("#detail-modal").modal("show")
                            if(response.data.payment_receipt == null)
                                app.image = null
                            else
                                app.image = response.data.payment_receipt_url.replace('public','')
                        }
                    })
                },
                onFileChange(e) {
                    this.canSave = true
                    this.imageNotBase64 = e.target.files[0]
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createImage(files[0]);
                },
                createImage(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                resetForm() {
                    this.canSave = false
                },
                saveImage() {
                    let requestData = new FormData()

                    requestData.append('file', app.imageNotBase64)
                    requestData.set('id', app.selectedTuition.id)

                    $("#detail-modal").modal("hide")

                    axios.post("{{ url('student/save-image') }}", requestData)
                    .then(function (response) {
                        if(response.data) {
                            app.resetForm()
                            $("#detail-modal").modal("hide")
                        }
                    })
                }
            }
        })
    </script>
@endsection