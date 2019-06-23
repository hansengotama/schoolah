<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Attendance;
use App\Guardian;
use App\PeriodDateDetail;
use App\ScheduleClass;
use App\ScheduleDetail;
use App\ScheduleShift;
use App\Student;
use App\StudentClass;
use App\StudentPacket;
use App\TuitionHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
{
    public function scheduleGuardianView()
    {
        return view('user.guardian.schedule');
    }

    public function informationGuardianView()
    {
        return view('user.guardian.information');
    }

    public function tuitionGuardianView()
    {
        return view('user.guardian.tuition');
    }

    public function getStudent()
    {
        $userId = Auth::user()->id;
        $guardian = Guardian::where("user_id", $userId)->with(["students"=> function($query) {
            $query->with("user");
        }])->first();

        return response()->json($guardian, 200);
    }

    public function getSchedule($student_id)
    {
        $schoolId = Auth::user()->school_id;
        $now = Carbon::now();

        $periodDateDetail = PeriodDateDetail::where("school_id", $schoolId)
            ->whereDate("start_date", "<=", $now)
            ->whereDate("end_date", ">=", $now)
            ->first();

        $studentClasses = StudentClass::where("student_id", $student_id)
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

    public function getStudentDetail($student_id)
    {
        $student = Student::where("id", $student_id)->with("user")->first();

        return response()->json($student, 200);
    }

    public function getStudentExamAndQuizScore($student_id)
    {
        $studentPackets = StudentPacket::where("student_id", $student_id)->with("packet")->get();

        return response()->json($studentPackets, 200);
    }

    public function getStudentAttendance($student_id)
    {
        $attendance = Attendance::where("student_id", $student_id)->where("status","!=", "present")->with(['scheduleClass' => function($query) {
            $query->with('course');
        }])->get();

        return response()->json($attendance, 200);
    }

    public function getTuitions($student_id)
    {
        $schoolId = Auth::user()->school_id;
        $now = Carbon::now();

        $periodDateDetail = PeriodDateDetail::where("school_id", $schoolId)
            ->where("start_date", "<=", $now)
            ->where("end_date", ">=", $now)
            ->first();

        $studentClasses = StudentClass::where("student_id", $student_id)
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

        $tuitionHistories = TuitionHistory::where("student_id", $student_id)
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
}
