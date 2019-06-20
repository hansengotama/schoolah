<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Forum;
use App\Material;
use App\Packet;
use App\PeriodDateDetail;
use App\QuestionChoice;
use App\ScheduleClass;
use App\ScheduleDetail;
use App\ScheduleShift;
use App\Student;
use App\StudentAnswer;
use App\StudentAssignment;
use App\StudentClass;
use App\StudentPacket;
use App\Teacher;
use App\TeacherClass;
use App\Tuition;
use App\TuitionHistory;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function studentScheduleView()
    {
        return view('user.student.schedule');
    }

    public function studentQuizView()
    {
        return view('user.student.quiz');
    }

    public function tuitionView()
    {
        return view('user.student.tuition');
    }

    public function assignmentView()
    {
        return view('user.student.assignment');
    }

    public function courseView()
    {
        return view('user.student.course');
    }

    public function examView()
    {
        return view('user.student.exam');
    }

    public function getSchedule()
    {
        $schoolId = Auth::user()->school_id;
        $user_id = Auth::user()->id;
        $now = Carbon::now();

        $student = Student::where("user_id", $user_id)->first();
        $periodDateDetail = PeriodDateDetail::where("school_id", $schoolId)
            ->whereDate("start_date", "<=", $now)
            ->whereDate("end_date", ">=", $now)
            ->first();

        $studentClasses = StudentClass::where("student_id", $student->id)
            ->with(["grade" => function ($query) use ($periodDateDetail) {
                $query->where("period", $periodDateDetail->period);
            }])
            ->get();

        $scheduleClasses = null;
        $classSchedules = [];
        foreach ($studentClasses as $studentClass) {
            if ($studentClass->grade != null) {
                $scheduleClasses = ScheduleClass::where("grade_id", $studentClass->grade->id)
                    ->with(["course", "teacher" => function ($query) {
                        $query->with("user");
                    }])
                    ->get();

                break;
            }
        }

        foreach ($scheduleClasses as $schedule_class) {
            $start = new \DateTime($periodDateDetail->start_date);
            $end = new \DateTime($periodDateDetail->end_date);
            if ($start->format("w") < $end->format("w"))
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
                if ($totalPeriod == $count)
                    $num = (int)$end->format("d");

                for ($dayNumber = ($count == 1) ? (int)$dt->format("d") : 0; $dayNumber <= $num; $dayNumber++) {
                    $date = new \DateTime($year . "-" . $month . "-" . $dayNumber);
                    $day = (int)$date->format("w");

                    if ($schedule_class->day === $day) {
                        $shift = ScheduleShift::where("school_id", $schoolId)
                            ->where("shift", $schedule_class->order)
                            ->whereDate("active_from_date", "<=", $date)
                            ->whereDate("active_until_date", ">=", $date)
                            ->first();

                        if ($shift == null) {
                            $shift = ScheduleShift::where("school_id", $schoolId)
                                ->where("shift", $schedule_class->order)
                                ->where("active_from_date", null)
                                ->where("active_until_date", null)
                                ->first();
                        }

                        ($dayNumber >= 10) ?: $dayNumber = "0" . $dayNumber;

                        $startDate = $year . "-" . $month . "-" . $dayNumber . "T" . $shift->from;
                        $endDate = $year . "-" . $month . "-" . $dayNumber . "T" . $shift->until;

                        $title = $schedule_class->course->name . " (" . $schedule_class->teacher->user->name . ")";

                        $object = new \stdClass();
                        $object->start = $startDate;
                        $object->end = $endDate;
                        $object->title = $title;
                        $object->date = $year . "-" . $month . "-" . $dayNumber . " " . "00:00:00";

                        $classSchedules[] = $object;
                    }
                }
            }
        }

        $scheduleExams = ScheduleDetail::where("school_id", $schoolId)
            ->where("class_id", $studentClass->grade->id)
            ->where("schedule_type", "exam")
            ->with(["scheduleDetailPacket" => function ($query) {
                $query->with(["packet" => function ($query) {
                    $query->with(["course"]);
                }]);
            }])
            ->get();

        $scheduleHolidays = ScheduleDetail::where("school_id", $schoolId)
            ->where("class_id", $studentClass->grade->id)
            ->where("schedule_type", "holiday")
            ->get();

        foreach ($classSchedules as $key => $classSchedule) {
            foreach ($scheduleHolidays as $scheduleHoliday) {
                if ($classSchedule->date === $scheduleHoliday->date)
                    unset($classSchedules[$key]);
            }

            foreach ($scheduleExams as $scheduleExam) {
                if ($classSchedule->date === $scheduleExam->date)
                    unset($classSchedules[$key]);
            }
        }

        foreach ($scheduleExams as $scheduleExam) {
            $shift = ScheduleShift::where("school_id", $schoolId)
                ->where("shift", $schedule_class->order)
                ->whereDate("active_from_date", "<=", $date)
                ->whereDate("active_until_date", ">=", $date)
                ->first();

            if ($shift == null) {
                $shift = ScheduleShift::where("school_id", $schoolId)
                    ->where("shift", $schedule_class->order)
                    ->where("active_from_date", null)
                    ->where("active_until_date", null)
                    ->first();
            }

            $date = new \DateTime($scheduleExam->date);
            $year = $date->format("Y");
            $month = $date->format("m");
            $dayNumber = $date->format("d");

            $startDate = $year . "-" . $month . "-" . $dayNumber . "T" . $shift->from;
            $endDate = $year . "-" . $month . "-" . $dayNumber . "T" . $shift->until;
            $title = $scheduleExam->scheduleDetailPacket->packet->course->name;

            $object = new \stdClass();
            $object->start = $startDate;
            $object->end = $endDate;
            $object->title = $title;
            $object->backgroundColor = "#c55964";
            $object->borderColor = "#c55964";
            $object->borderColor = "#c55964";

            $classSchedules[] = $object;
        }

        return response()->json($classSchedules, 200);
    }

    public function getCourse()
    {
        $schoolId = Auth::user()->school_id;
        $user_id = Auth::user()->id;
        $now = Carbon::now();

        $student = Student::where("user_id", $user_id)->first();
        $periodDateDetail = PeriodDateDetail::where("school_id", $schoolId)
            ->where("start_date", "<=", $now)
            ->where("end_date", ">=", $now)
            ->first();

        $studentClasses = StudentClass::where("student_id", $student->id)
            ->with(["grade" => function ($query) use ($periodDateDetail) {
                $query->where("period", $periodDateDetail->period);
            }])
            ->get();

        $class = null;

        foreach ($studentClasses as $studentClass) {
            if ($studentClass->grade != null) {
                $class = $studentClass;

                break;
            }
        }

        $scheduleClasses = TeacherClass::where('grade_id', $class->grade_id)
            ->select("course_id", "grade_id", "teacher_id")
            ->with(["course", "teacher", "grade"])
            ->get()
            ->unique('course_id');

        return response()->json($scheduleClasses, 200);
    }

    public function getQuizPacket($level, $course_id)
    {
        $schoolId = Auth::user()->school_id;

        $packets = Packet::where("school_id", $schoolId)
            ->where("type", "Quiz")
            ->where("course_id", $course_id)
            ->where("level", $level)
            ->inRandomOrder();

        $packet = $packets->first();
        $packet_used_questions = $packet->total_used_question;

        $packet = Packet::where("id", $packet->id)->with(["question" => function ($query) use ($packet_used_questions) {
            $query->with(["questionChoices" => function ($query) {
                $query->inRandomOrder();
            }])
                ->inRandomOrder()
                ->take($packet_used_questions);
        }])->first();

        return response()->json($packet, 200);
    }

    public function checkAnswer(Request $request)
    {
        $user_id = Auth::user()->id;
        $student = Student::where("user_id", $user_id)->first();

        $results = [];
        $resultTrue = 0;
        $totalQuestion = 0;
        foreach ($request->question_answers as $question_answer) {
            $questionChoice = QuestionChoice::where("id", $question_answer["choice_id"])
                ->where("question_id", $question_answer["question_id"])
                ->first();

            if ($questionChoice) {
                $results = array_merge($results, [[
                    "result" => $questionChoice->is_answer,
                    "question_choice_id" => $questionChoice->id,
                    "question_id" => $question_answer["question_id"]
                ]]);
                if ($questionChoice->is_answer == 1)
                    $resultTrue++;
            } else {
                $results = array_merge($results, [[
                    "result" => 0,
                    "question_id" => $question_answer["question_id"],
                    "question_choice_id" => null
                ]]);
            }

            $totalQuestion++;
        }

        $resultFalse = $totalQuestion - $resultTrue;
        $point = $resultTrue * 2;

        $studentPacket = StudentPacket::create([
            "student_id" => $student->id,
            "packet_id" => $request->packet_id,
            "score" => $point
        ]);

        foreach ($results as $result) {
            StudentAnswer::create([
                "student_packet_id" => $studentPacket->id,
                "question_id" => $result["question_id"],
                "question_choice_id" => $result["question_choice_id"]
            ]);
        }

        $percentage = ($resultTrue / $totalQuestion) * 100;
        $object = new \stdClass();
        $object->result_false = $resultFalse;
        $object->result_true = $resultTrue;
        $object->total_question = $totalQuestion;
        $object->percentage = $percentage;

        return response()->json($object, 200);
    }

    public function getPacketHistoryByCourseId($course_id)
    {
        $schoolId = Auth::user()->school_id;
        $user_id = Auth::user()->id;
        $student = Student::where("user_id", $user_id)->first();

        $packets = Packet::where("school_id", $schoolId)
            ->where("course_id", $course_id)
            ->with(["studentPackets" => function ($query) use ($student) {
                $query->where("student_id", $student->id)->orderBy("created_at", 'desc');
            }])
            ->get();

        $studentPackets = [];
        $totalScore = 0;
        foreach ($packets as $packet) {
            foreach ($packet->studentPackets as $studentPacket) {
                $totalScore = $totalScore + $studentPacket->score;
                $object = new \stdClass();
                $object->student_packet_id = $studentPacket->id;
                $object->packet_id = $studentPacket->packet_id;
                $object->score = $studentPacket->score;
                $object->created_at = date("d M Y", strtotime($studentPacket->created_at));
                $object->time = date("H:i:s", strtotime($studentPacket->created_at));
                $studentPackets[] = $object;
            }
        }

        $data = [
            "total_score" => $totalScore,
            "student_packets" => $studentPackets
        ];

        return response()->json($data, 200);
    }

    public function getPacketHistoryDetail($student_packet_id)
    {
        $studentAnswers = StudentAnswer::where("student_packet_id", $student_packet_id)
            ->with(["questionChoice", "question" => function ($query) {
                $query->with("questionChoices");
            }])
            ->get();

        return response()->json($studentAnswers, 200);
    }

    public function getTuitions()
    {
        $schoolId = Auth::user()->school_id;
        $user_id = Auth::user()->id;
        $now = Carbon::now();

        $student = Student::where("user_id", $user_id)->first();
        $periodDateDetail = PeriodDateDetail::where("school_id", $schoolId)
            ->where("start_date", "<=", $now)
            ->where("end_date", ">=", $now)
            ->first();

        $studentClasses = StudentClass::where("student_id", $student->id)
            ->with(["grade" => function ($query) use ($periodDateDetail) {
                $query->where("period", $periodDateDetail->period);
            }])
            ->get();

        $class = null;

        foreach ($studentClasses as $studentClass) {
            if ($studentClass->grade != null) {
                $class = $studentClass;

                break;
            }
        }

        $tuitionHistories = TuitionHistory::where("student_id", $student->id)
            ->where("class_id", $class->grade_id)
            ->with("tuition")
            ->get();

        $tuitionDetails = [];

        foreach ($tuitionHistories as $tuitionHistory) {
            $object = new \stdClass();
            $object->tuiton_history_id = $tuitionHistory->id;
            $object->tuition_price = "Rp. " . number_format($tuitionHistory->tuition->price, "0", ",", ".");
            $object->tuition_description = $tuitionHistory->tuition->description;
            $object->status = $tuitionHistory->status;
            $object->payment_receipt = $tuitionHistory->payment_receipt;
            $object->due_date = date("d M Y", strtotime($tuitionHistory->tuition->due_date));
            $tuitionDetails[] = $object;
        }

        return response()->json($tuitionDetails, 200);
    }

    public function getHistoryDetail($tuition_history_id)
    {
        $tuition_history = TuitionHistory::where("id", $tuition_history_id)->first();

        return response()->json($tuition_history, 200);
    }

    public function saveImage(Request $request)
    {
        $tuition_history = TuitionHistory::where("id", $request->id)->first();
        $payment_receipt = $tuition_history->payment_receipt;
        Storage::delete($payment_receipt);

        $image = $request->file->store('/public/tuition');

        $tuition_history->update([
            "payment_receipt" => $image,
            "status" => "pending"
        ]);

        return response()->json($tuition_history, 200);
    }

    public function getTeacherProfile($grade_id, $course_id)
    {
        $teacher_class = TeacherClass::where("grade_id", $grade_id)
            ->where("course_id", $course_id)
            ->with(["course", "teacher" => function ($query) {
                $query->with("user");
            }])
            ->first();

        return response()->json($teacher_class, 200);
    }

    public function getAssignmentByGrade()
    {
        $schoolId = Auth::user()->school_id;
        $user_id = Auth::user()->id;
        $now = Carbon::now();

        $student = Student::where("user_id", $user_id)->first();
        $periodDateDetail = PeriodDateDetail::where("school_id", $schoolId)
            ->where("start_date", "<=", $now)
            ->where("end_date", ">=", $now)
            ->first();

        $studentClasses = StudentClass::where("student_id", $student->id)
            ->with(["grade" => function ($query) use ($periodDateDetail) {
                $query->where("period", $periodDateDetail->period);
            }])
            ->get();

        $class = null;

        foreach ($studentClasses as $studentClass) {
            if ($studentClass->grade != null) {
                $class = $studentClass;

                break;
            }
        }

        $teacherClasses = TeacherClass::where("grade_id", $class->grade_id)->pluck("id");
        $materials = Assignment::whereIn("teacher_class_id", $teacherClasses)->with(['teacherClass' => function ($query) {
            $query->with(["course", "teacher"]);
        }])->orderBy("due_date")->get();

        return response()->json($materials, 200);
    }

    public function getMaterialByTeacherClassId($teacher_class_id)
    {
        $materials = Material::where("teacher_class_id", $teacher_class_id)->get();
        foreach ($materials as $material) {
            $material->createdAt = Carbon::parse($material->created_at)->format('d M Y');
        }

        return response()->json($materials, 200);
    }

    public function uploadAssignment(Request $request)
    {
        $user_id = Auth::user()->id;
        $student = Student::where("user_id", $user_id)->first();

        $file = $request->file->store('/public/student/assignment');

        StudentAssignment::create([
            "assignment_id" => $request->id,
            "student_id" => $student->id,
            "answer_file" => $file
        ]);

        return response()->json($request->all(), 200);
    }

    public function getHistoryAssignment($id)
    {
        $user_id = Auth::user()->id;
        $student = Student::where("user_id", $user_id)->first();
        $studentAssignments = StudentAssignment::where("assignment_id", $id)
                            ->where("student_id", $student->id)
                            ->get();

        return response()->json($studentAssignments, 200);
    }

    public function getExam()
    {
        $schoolId = Auth::user()->school_id;
        $user_id = Auth::user()->id;
        $now = Carbon::now();

        $student = Student::where("user_id", $user_id)->first();
        $periodDateDetail = PeriodDateDetail::where("school_id", $schoolId)
            ->where("start_date", "<=", $now)
            ->where("end_date", ">=", $now)
            ->first();

        $studentClasses = StudentClass::where("student_id", $student->id)
            ->with(["grade" => function ($query) use ($periodDateDetail) {
                $query->where("period", $periodDateDetail->period);
            }])
            ->get();

        $class = null;

        foreach ($studentClasses as $studentClass) {
            if ($studentClass->grade != null) {
                $class = $studentClass;

                break;
            }
        }

        $gradeId = $class->id;

        $scheduleDetails = ScheduleDetail::where("class_id", $gradeId)
                        ->where('schedule_type', 'exam')
                        ->whereDate('date', $now)
                        ->with(["scheduleDetailPacket" => function($query) {
                            $query->with(['packet' => function($query) {
                                $query->with(['question' => function($query) {
                                    $query->with(['questionChoices' => function($query) {
                                        $query->inRandomOrder();
                                    }])->inRandomOrder();
                                }]);
                            }]);
                        }])
                        ->get();

        $examNow = null;

        if($scheduleDetails) {
            foreach ($scheduleDetails as $scheduleDetail) {
                $studentPacket = StudentPacket::where("student_id", $student->id)
                    ->where("packet_id", $scheduleDetail->scheduleDetailPacket->packet_id)
                    ->first();
                if($studentPacket) {
                    continue;
                }else {
                    $scheduleShift = ScheduleShift::where("shift", 6)
                        ->whereDate("active_from_date", "<=", $now)
                        ->whereDate("active_until_date", ">=", $now)
                        ->first();

                    if($scheduleShift) {
                        $time = ScheduleShift::where("shift", 6)
                            ->whereDate("active_from_date", "<=", $now)
                            ->whereDate("active_until_date", ">=", $now)
                            ->where("from", "<=", $now)
                            ->where("until", ">=", $now)
                            ->first();
                        if($time) {
                            $examNow = new \stdClass();
                            $examNow->schedule_detail = $scheduleDetail;
                            $examNow->schedule_shift = $time;
                            break;
                        }else {
                            continue;
                        }
                    }else {
                        $scheduleShiftDefault = ScheduleShift::where("shift", 6)
                            ->where("from", "<=", $now)
                            ->where("until", ">=", $now)
                            ->first();

                        if($scheduleShiftDefault) {
                            $examNow = new \stdClass();
                            $examNow->schedule_detail = $scheduleDetail;
                            $examNow->schedule_shift = $scheduleShiftDefault;
                            break;
                        }else {
                            continue;
                        }
                    }
                }
            }
        }

        return response()->json($examNow, 200);
    }
}
