@extends('layouts.app-admin')

@section('css')

@endsection

@section('content')
<section class="information">
    <div>
        Tuition
        Exam Score
    </div>
</section>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                student_id: "",

            },
            mounted() {
                this.getStudentId()
            },
            methods: {
                getStudentId() {
                    this.student_id = Cookies.get("student_id")
                    console.log(this.student_id)
                },

            }
        })
    </script>
@endsection