<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\ContributorTeacher;
use App\Packet;
use App\PeriodDateDetail;
use App\Question;
use App\QuestionChoice;
use App\ScheduleClass;
use App\ScheduleDetail;
use App\ScheduleShift;
use App\Teacher;
use App\TeacherClass;
use Carbon\Carbon;
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

    public function manageScheduleView()
    {
        return view('user.teacher.schedule');
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

        return response()->json($request->all(), 200);
    }

    public function getSchedule()
    {
        $schoolId = Auth::user()->school_id;
        $user_id = Auth::user()->id;

        $teacher = Teacher::where("user_id", $user_id)->first();
        $teacher_id = $teacher->id;
        $schedule_classes = ScheduleClass::where("teacher_id", $teacher_id)
            ->with(["grade", "course"])
            ->orderBy('day' ,'asc')
            ->get();

        $classSchedules = [];

        foreach ($schedule_classes as $schedule_class) {
            $period = $schedule_class->grade->period;
            $periodDateDetail = PeriodDateDetail::where("period", $period)
                ->where("school_id", $schoolId)
                ->first();

            if($periodDateDetail) {
                $start = new \DateTime($periodDateDetail->start_date);
                $end = new \DateTime($periodDateDetail->end_date);
                if($start->format("w") < $end->format("w"))
                    $end = $end->modify('+1 month');

                $interval = \DateInterval::createFromDateString('1 month');
                $period = new \DatePeriod($start, $interval, $end);
                $totalPeriod = iterator_count($period);
                $count = 0;
                foreach ($period as $dt) {
                    $year = $dt->format("Y");
                    $month = $dt->format("m");
                    $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                    $count++;

                    if($totalPeriod == $count)
                        $num = (int)$end->format("d");

                    for ($dayNumber = ($count == 1) ? (int)$dt->format("d") : 0; $dayNumber <= $num; $dayNumber++) {
                        $date = new \DateTime($year . "-" . $month . "-" . $dayNumber);
                        $day = (int)$date->format("w");

                        if($schedule_class->day === $day) {
                            $shift = ScheduleShift::where("school_id", $schoolId)
                                ->where("shift", $schedule_class->order)
                                ->whereDate("active_from_date", "<=", $date)
                                ->whereDate("active_until_date", ">=", $date)
                                ->first();

                            if($shift == null) {
                                $shift = ScheduleShift::where("school_id", $schoolId)
                                    ->where("shift", $schedule_class->order)
                                    ->where("active_from_date", null)
                                    ->where("active_until_date", null)
                                    ->first();
                            }

                            ($dayNumber >= 10) ?: $dayNumber = "0" . $dayNumber;

                            $startDate = $year . "-" . $month . "-" . $dayNumber. "T" .$shift->from;
                            $endDate = $year . "-" . $month . "-" . $dayNumber. "T" .$shift->until;
                            $title = $schedule_class->grade->name . " (" . $schedule_class->course->name . ")";

                            $object = new \stdClass();
                            $object->start = $startDate;
                            $object->end = $endDate;
                            $object->title = $title;
                            $object->class = $schedule_class->grade->id;
                            $object->date = $year . "-" . $month . "-" . $dayNumber . " " . "00:00:00";

                            $classSchedules[] = $object;
                        }
                    }
                }
            }
        }

        $scheduleDetails = ScheduleDetail::where("school_id", $schoolId)
            ->where(function ($query) {
                $query->where("schedule_type", "exam")
                    ->orWhere("schedule_type", "holiday");
            })
            ->get();

        $classHolidays = [];
        foreach ($scheduleDetails as $scheduleDetail) {
            $class_id = $scheduleDetail->class_id;
            $date = $scheduleDetail->date;

            $object = new \stdClass();
            $object->class = $class_id;
            $object->date = $date;
            $classHolidays[] = $object;
        }

        foreach ($classSchedules as $key => $classSchedule) {
            foreach($classHolidays as $classHoliday) {
                if($classSchedule->date === $classHoliday->date && $classSchedule->class === $classHoliday->class)
                    unset($classSchedules[$key]);
            }
        }

        return response()->json($classSchedules, 200);
    }

    public function getTeacherClasses()
    {
        $schoolId = Auth::user()->school_id;
        $user_id = Auth::user()->id;
        $now = Carbon::now();

        $periodDateDetail = PeriodDateDetail::where("school_id", $schoolId)
            ->whereDate("start_date", "<=", $now)
            ->whereDate("end_date", ">=", $now)
            ->first();

        $period = $periodDateDetail->period;

        $teacher = Teacher::where("user_id", $user_id)->first();

        $teacher_id = $teacher->id;

        $teacher_classes = TeacherClass::where("teacher_id", $teacher_id)
            ->with(["course", "grade" => function($query) use($period) {
                $query->where("period", $period);
            }])
            ->orderBy("grade_id", "ASC")
            ->get();

        return response()->json($teacher_classes, 200);
    }

    public function getTeacherClassById($teacher_class_id)
    {
        $teacher_class = TeacherClass::where("id", $teacher_class_id)->first();

        return response()->json($teacher_class, 200);
    }

    public function addAssignment(Request $request)
    {
        $file = $request->file->store('/public/assignment');

        Assignment::create([
            "teacher_class_id" => $request->teacher_class_id,
            "name" => $request->name,
            "question_file" => $file,
            "description" => $request->description,
            "due_date" => $request->due_date,
        ]);

        return response()->json($request->all(), 200);
    }

    public function getAssignments($teacher_class_id)
    {
        $assignments = Assignment::where("teacher_class_id", $teacher_class_id)->get();

        return response()->json($assignments, 200);
    }
}
