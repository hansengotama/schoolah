<?php

namespace App\Http\Controllers;

use App\ContributorTeacher;
use App\Packet;
use App\Question;
use App\QuestionChoice;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function manageClassView()
    {
        return view('user.teacher.class');
    }

    public function managePacketQuestionView()
    {
        return view('user.teacher.packet-question');
    }

    public function packetQuestion()
    {
        $userId = Auth::id();

        $teacher = Teacher::where('user_id', $userId)->first();
        $packetId = ContributorTeacher::where("teacher_id", $teacher->id)->pluck('packet_id');
        $packets = Packet::whereIn("id", $packetId)->with('course')->get();

        return response()->json($packets, 200);
    }

    public function addQuestion(Request $request)
    {
        $question = Question::create([
            "packet_id" => $request->packetId,
            "text" => $request->question
        ]);

        $flag = 1;
        foreach ($request->choices as $key => $choice) {
            $answer = false;

            if($request->answer == $flag) {
                $answer = true;
            }else {
                $answer = false;
            }

            QuestionChoice::create([
                "question_id" => $question->id,
                "text" => $choice,
                "is_answer" => $answer
            ]);

            $flag++;
        }

        return response()->json($request->all(), 200);
    }

    public function getAllQuestion($packetId)
    {
        $questions = Question::where("packet_id", $packetId)->with(['questionChoices'])->get();

        return response()->json($questions, 200);
    }

    public function getQuestionById($questionId)
    {
        $question = Question::where("id", $questionId)->with(['questionChoices'])->first();

        return response()->json($question, 200);
    }

    public function deleteQuestion(Request $request)
    {
        $question = Question::where("id", $request->questionId)->first();
        $question->delete();

        return response()->json($question, 200);
    }

    public function editQuestion(Request $request)
    {
        $question = Question::where("id", $request->questionId)->first();
        $question->update([
            "text" => $request->question
        ]);

        $flag = 1;
        $questionChoices = QuestionChoice::where("question_id", $question->id)->pluck("id");
        foreach ($questionChoices as $key => $choice) {
            $answer = false;

            if($request->answer == $flag) {
                $answer = true;
            }else {
                $answer = false;
            }

            QuestionChoice::where("id", $choice)->update([
                "text" => $request->choices[$key],
                "is_answer" => $answer
            ]);

            $flag++;
        }
    }
}
