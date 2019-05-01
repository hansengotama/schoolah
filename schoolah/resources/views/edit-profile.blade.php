@extends('layouts.app-admin')

@section('css')
    <style>

    </style>
@endsection

@section('content')
<section class="edit-profile">
    <div class="row justify-content-center">
        <div class="container">
            <div class="mt-5">
                <h3>Edit Profile</h3>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" :value="formData.name" disabled>
            </div>
            <div class="form-group" v-if="formData.role == 'student' || formData.role =='teacher'">
                <label v-if="formData.role == 'student'">Student Code</label>
                <label v-if="formData.role == 'teacher'">Teacher Code</label>
                <input type="text" class="form-control" :value="formData.code" disabled>
            </div>
            <div v-if="formData.role == 'student' || formData.role =='teacher'">
                <div><label>Photo</label></div>
                <label for="upload">
                    <img :src="formData.image" alt="" style="width:15em !important; cursor: pointer">
                    <input type="file" id="upload" style="display: none" accept="image/*" @change="onFileChange">
                </label>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" :class="'form-control '+error.class.email" v-model="formData.email">
                <div class="red">@{{ error.text.email }}</div>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" :class="'form-control '+error.class.phoneNumber" v-model="formData.phoneNumber">
                <div class="red">@{{ error.text.phoneNumber }}</div>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea :class="'form-control '+error.class.address" v-model="formData.address"></textarea>
                <div class="red">@{{ error.text.address }}</div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary button-color" @click="validateProfile()">Edit Profile</button>
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
                formData: {
                    code: "",
                    name: "",
                    email: "",
                    phoneNumber: "",
                    address: "",
                    image: "",
                    role: "",
                    imageNotBase64: null
                },
                error: {
                    class: {
                        email: "",
                        phoneNumber: "",
                        address: "",
                    },
                    text: {
                        email: "",
                        phoneNumber: "",
                        address: "",
                    }
                },
            },
            mounted() {
                this.getUserData()
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
                getUserData() {
                    axios.get('{{ url('get-user-data') }}')
                    .then(function (response) {
                        if(response.status == 200) {
                            let data = response.data
                            app.formData.name = data.name
                            app.formData.email = data.email
                            app.formData.phoneNumber = data.phone_number
                            app.formData.address = data.address
                            app.formData.role = data.role
                            if(app.formData.role == "student" || app.formData.role == "teacher") {
                                app.formData.image = data.avatar
                                if(app.formData.image == "img/no-pict") {
                                    app.formData.image = data.avatar+".png"
                                }else {
                                    app.formData.image = data.avatar.replace('public/','')
                                }

                                if(app.formData.role == "student") {
                                    app.formData.code = data.student_code
                                }else {
                                    app.formData.code = data.teacher_code
                                }
                            }
                        }
                    })
                },
                onFileChange(e) {
                    this.formData.imageNotBase64 = e.target.files[0]
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createImage(files[0]);
                },
                createImage(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.formData.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                validateProfile() {
                    if(this.required(this.formData.email)) {
                        this.error.text.email = "email must be filled"
                        this.error.class.email = "border-red"
                    }else if(this.emailFormat(this.formData.email)){
                        this.error.text.email = "email must be formatted correctly"
                        this.error.class.email = "border-red"
                    }else {
                        this.error.text.email = ""
                        this.error.class.email = ""
                    }

                    if(this.required(this.formData.phoneNumber)) {
                        this.error.text.phoneNumber = "phone number must be filled"
                        this.error.class.phoneNumber = "border-red"
                    }else if(this.isNumber(this.formData.phoneNumber)) {
                        this.error.text.phoneNumber = "phone number must be filled"
                        this.error.class.phoneNumber = "border-red"
                    }else {
                        this.error.text.phoneNumber = ""
                        this.error.class.phoneNumber = ""
                    }

                    if(this.required(this.formData.address)) {
                        this.error.text.address = "address must be filled"
                        this.error.class.address = "border-red"
                    }else {
                        this.error.text.address = ""
                        this.error.class.address = ""
                    }

                    if(this.error.class.email == "" && this.error.class.phoneNumber == "" && this.error.class.address == "") {
                        this.confirmEdit()
                    }
                },
                confirmEdit() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, edit it!'
                    }).then((result) => {
                        if (result.value) {
                            this.editProfile()
                        }
                    })
                },
                editProfile() {
                    let requestData = new FormData()
                    requestData.set('email', app.formData.email)
                    requestData.set('phoneNumber', app.formData.phoneNumber)
                    requestData.set('address', app.formData.address)
                    if(app.formData.imageNotBase64)
                        requestData.append('file', app.formData.imageNotBase64)
                    axios.post('edit-profile-action', requestData)
                    .then(function (response) {
                        if(response.status == 200) {
                            app.popUpSuccess()
                            app.getUserData()
                            document.location.href="/"
                        }else {
                            app.popUpError()
                            app.getUserData()
                        }
                    })
                    .catch(function (error) {
                        app.popUpError()
                        app.getUserData()
                    })
                }
            }
        })
    </script>
@endsection