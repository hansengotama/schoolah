@extends('layouts.app-admin')

@section('css')
    <style>
        .title-font {
            border-bottom: 6px solid #51a9c5;
            padding-bottom: 6px;
            font-size: 50px;
            color: #51a9c5;
        }
        .info-exam {
            background-color: aliceblue;
            padding: 22px;
        }
        .timer {
            position: fixed;
            font-size: 32px;
            margin-left: 29em;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .background-answer {
            background: #99cada;
            border-radius: 25px;
            padding-left: 15px;
        }
        .timer-duration {
            font-size: 32px;
            margin-bottom: 5px;
        }
        .check-question.notanswered{
            background-color: #fce8e6;
        }
        .correctanswer {
            background: #99cada;
            border-radius: 25px;
            padding-left: 15px;
        }
        .wronganswer {
            background: red;
            border-radius: 25px;
            padding-left: 15px;
        }
        .notanswer {
            background: #d88db4;
            border-radius: 25px;
            padding-left: 15px;
        }
        .pad-left-15 {
            padding-left: 15px;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="ui container mt-5 mb-5">
        <div>
            Exam Score
        </div>
    </div>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: "#app",
            data: {},
            mounted() {},
            methods: {
                moment(date) {
                    return moment(date).format("D MMMM Y")
                },
            }
        })
    </script>
@endsection