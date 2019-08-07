<?php

namespace App\Http\Controllers;

use App\TuitionHistory;
use App\ContributorTeacher;
use App\Course;
use App\Grade;
use App\Guardian;
use App\Packet;
use App\PeriodDateDetail;
use App\ScheduleClass;
use App\ScheduleDetail;
use App\ScheduleDetailPacket;
use App\ScheduleShift;
use App\School;
use App\Student;
use App\Teacher;
use App\User;
use App\Tuition;
use App\StudentClass;
use App\TeacherClass;
use Carbon\Carbon;
use App\Mail\SendEmail;
use App\Mail\SendEmailTuition;
use App\Mail\SendEmailTuitionParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StaffController extends Controller
{
    public function manageTeacherView()
    {
        return view('user.staff.teacher');
    }

    public function getAllTeacher()
    {
        $userId = Auth::user()->id;
        $staffLogin = User::where("id", $userId)->first();

        $teachers = User::where("school_id", $staffLogin->school_id)->where("role", "teacher")->get();

        foreach ($teachers as $teacher) {
            $teacherId = $teacher->id;
            $teacherDetail = Teacher::where("user_id", $teacherId)->first();
            $teacher->teacher_code = $teacherDetail->teacher_code;
            $teacher->teacher_id = $teacherDetail->id;
        }

        return response()->json($teachers, 200);
    }

    public function addTeacher(Request $request)
    {
        $userId = Auth::user()->id;
        $staffLogin = User::where("id", $userId)->first();

        $schoolId = $staffLogin->school_id;
        $school = School::where('id', $schoolId)->first();

        $teacherPassword = str_random(8);

        $data = [
            "school_name" => $school->name,
            "password" => $teacherPassword,
            "role" => 'teacher'
        ];
        $data = array_merge($data, $request->all());

        $teacher = User::create([
            'name' => $request->name,
            'role' => 'teacher',
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phoneNumber,
            'school_id' => $schoolId,
            'password' => bcrypt($teacherPassword),
            'is_change_password' => false
        ]);

        Teacher::create([
            'user_id' => $teacher->id,
            'teacher_code' => $request->teacherCode,
            'avatar' => "img/no-pict"
        ]);

        Mail::to($request->email)->send(new SendEmail('Teacher', $data));

        return response()->json($request->all(), 200);
    }

    public function getTeacher(Request $request)
    {
        $teacher = User::where("id", $request->id)->first();
        $teacherDetail = Teacher::where("user_id", $request->id)->first();
        $teacher->teacher_code = $teacherDetail->teacher_code;

        return response()->json($teacher, 200);
    }

    public function findTeacher(Request $request)
    {
        $teacherDetail = Teacher::where("id", $request->id)->first();
        $teacher = User::where("id", $teacherDetail->user_id)->first();
        $teacher->teacher_code = $teacherDetail->teacher_code;

        return response()->json($teacher, 200);
    }

    public function findTeacherByUserId($user_id)
    {
        $teacher = User::where("id", $user_id)->first();
        $teacherDetail = Teacher::where("user_id", $user_id)->first();
        $teacher->teacher_code = $teacherDetail->teacher_code;

        return response()->json($teacher, 200);
    }

    public function editTeacher(Request $request)
    {
        $teacher = User::where("id", $request->id)->first();

        $teacher->update([
            'name' => $request->name,
            'role' => 'teacher',
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phoneNumber,
            'school_id' => $teacher->school_id,
            'password' => $teacher->password,
            'is_change_password' => $teacher->is_change_password
        ]);

        $teacherDetail = Teacher::where("user_id", $request->id)->first();

        $teacherDetail->update([
            'user_id' => $teacher->id,
            'teacher_code' => $request->teacherCode,
            'avatar' => $teacherDetail->avatar
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteTeacher(Request $request)
    {
        Teacher::where("user_id", $request->id)->delete();
        User::where("id", $request->id)->delete();

        return response()->json($request->all(), 200);
    }

    public function manageClassView()
    {
        return view('user.staff.class');
    }

    public function getGuardianTeacher()
    {
        $schoolId = Auth::user()->school_id;
        $grade = Grade::where('school_id', $schoolId)->pluck('guardian_teacher_id')->all();
        $user = User::where('school_id', $schoolId)->pluck('id')->all();
        $teachers = Teacher::whereNotIn("id", $grade)
            ->whereIn("user_id", $user)
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->select('id as value', 'user_id')->get();

        $response = [];

        foreach ($teachers as $key => $teacher) {
            $response[$key]['value'] = $teacher->value;
            $response[$key]['guardianTeacherName'] = $teacher->user->name;
        }

        return response()->json($response, 200);
    }

    public function getGuardian()
    {
        $schoolId = Auth::user()->school_id;

        $guardians = User::where("school_id", $schoolId)
            ->where("role", "guardian")
            ->select('name', 'id')
            ->get();

        foreach ($guardians as $guardian) {
            $guardianDetail = Guardian::where("user_id", $guardian->id)->first();
            $guardian->value = $guardianDetail->id;
        }

        return response()->json($guardians, 200);
    }

    public function getAllClass()
    {
        $schoolId = Auth::user()->school_id;

        $classes = Grade::where('school_id', $schoolId)->get();

        foreach ($classes as $class) {
            $guardianTeacher = $class->guardian_teacher_id;
            $teacherDetail = Teacher::where('id', $guardianTeacher)->first();
            $teacher = User::where('id', $teacherDetail->user_id)->first();
            $class->guardian_teacher = $teacher->name;
        }

        return response()->json($classes, 200);
    }

    public function addClass(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        Grade::create([
            "school_id" => $schoolId,
            "guardian_teacher_id" => $request->guardianTeacherId,
            "name" => $request->name,
            "period" => $request->period,
            "level" => $request->level
        ]);

        return response()->json($request->all(), 200);
    }

    public function findClass(Request $request)
    {
        $class = Grade::where('id', $request->id)->first();
        $teacher = Teacher::where('id', $class->guardian_teacher_id)->with('user')->first();

        $class->select = collect();
        $class->select['value'] = $class->guardian_teacher_id;
        $class->select['guardianTeacherName'] = $teacher->user->name;

        return response()->json($class, 200);
    }

    public function editClass(Request $request)
    {
        $class = Grade::where("id", $request->id)->first();
        $schoolId = Auth::user()->school_id;

        $class->update([
            "school_id" => $schoolId,
            "guardian_teacher_id" => $request->guardianTeacherId,
            "name" => $request->name,
            "period" => $request->period,
            "level" => $request->level
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteClass(Request $request)
    {
        $class = Grade::where("id", $request->id)->first();
        $class->delete();

        return response()->json($request->all, 200);
    }

    public function manageGuardianView()
    {
        return view('user.staff.guardian');
    }

    public function getAllGuardian()
    {
        $schoolId = Auth::user()->school_id;
        $users = User::where("school_id", $schoolId)->where("role", "guardian")->get();

        return response()->json($users, 200);
    }

    public function addGuardian(Request $request)
    {
        $userId = Auth::user()->id;
        $staffLogin = User::where("id", $userId)->first();

        $schoolId = $staffLogin->school_id;
        $school = School::where('id', $schoolId)->first();

        $guardianPassword = str_random(8);

        $data = [
            "school_name" => $school->name,
            "password" => $guardianPassword,
            "role" => 'guardian'
        ];
        $data = array_merge($data, $request->all());

        $guardian = User::create([
            'name' => $request->name,
            'role' => 'guardian',
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phoneNumber,
            'school_id' => $schoolId,
            'password' => bcrypt($guardianPassword),
            'is_change_password' => false
        ]);

        Guardian::create([
            'user_id' => $guardian->id,
            'avatar' => "img/no-pict"
        ]);

        Mail::to($request->email)->send(new SendEmail('Guardian', $data));

        return response()->json($request->all(), 200);
    }

    public function findGuardian(Request $request)
    {
        $guardian = User::where("id", $request->id)->first();

        return response()->json($guardian, 200);
    }

    public function editGuardian(Request $request)
    {
        $guardian = User::where("id", $request->id)->first();

        $guardian->update([
            'name' => $request->name,
            'role' => 'guardian',
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phoneNumber,
            'school_id' => $guardian->school_id,
            'password' => $guardian->password,
            'is_change_password' => $guardian->is_change_password
        ]);

        $guardianDetail = Guardian::where("user_id", $request->id)->first();

        $guardianDetail->update([
            'user_id' => $guardian->id,
            'avatar' => $guardianDetail->avatar
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteGuardian(Request $request)
    {
        Guardian::where("user_id", $request->id)->delete();
        User::where("id", $request->id)->delete();

        return response()->json($request->all(), 200);
    }

    public function manageStudentView()
    {
        return view('user.staff.student');
    }

    public function manageTuitionView()
    {
        return view('user.staff.tuition');
    }

    public function getAllStudent($class_id)
    {
        $schoolId = Auth::user()->school_id;

        if ($class_id == 0) {
            $users = User::where("school_id", $schoolId)->where("role", "student")->get();
        } else {

        }
        foreach ($users as $user) {
            $studentDetail = Student::where("user_id", $user->id)->first();
            $user->studentCode = $studentDetail->student_code;
        }

        return response()->json($users, 200);
    }

    public function addStudent(Request $request)
    {
        $userId = Auth::user()->id;
        $staffLogin = User::where("id", $userId)->first();

        $schoolId = $staffLogin->school_id;
        $school = School::where('id', $schoolId)->first();

        $studentPassword = str_random(8);

        $data = [
            "school_name" => $school->name,
            "password" => $studentPassword,
            "role" => 'student'
        ];
        $data = array_merge($data, $request->all());

        $student = User::create([
            'name' => $request->name,
            'role' => 'student',
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phoneNumber,
            'school_id' => $schoolId,
            'password' => bcrypt($studentPassword),
            'is_change_password' => false
        ]);
        $studentId = $student->id;

        Student::create([
            'user_id' => $studentId,
            'guardian_id' => $request->guardianId,
            'student_code' => $request->studentCode,
            'avatar' => 'img/no-pict'
        ]);

        Mail::to($request->email)->send(new SendEmail('Student', $data));
        return response()->json($request->all(), 200);
    }

    public function findStudent($student_id)
    {
        $student = User::where('id', $student_id)->first();
        $studentDetail = Student::where('user_id', $student_id)->first();
        $student->guardianId = $studentDetail->guardian_id;
        $student->studentCode = $studentDetail->student_code;

        return response()->json($student, 200);
    }

    public function editStudent(Request $request)
    {
        $student = User::where("id", $request->id)->first();

        $student->update([
            'name' => $request->name,
            'role' => 'student',
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phoneNumber,
            'school_id' => $student->school_id,
            'password' => $student->password,
            'is_change_password' => $student->is_change_password
        ]);

        $studentDetail = Student::where("user_id", $request->id)->first();

        $studentDetail->update([
            'user_id' => $student->id,
            'avatar' => $studentDetail->avatar,
            'student_code' => $request->studentCode,
            'guardian_id' => $request->guardianId
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteStudent($student_id)
    {
        $user = User::where('id', $student_id)->first();
        $student = Student::where('user_id', $student_id)->first();
        $user->delete();
        $student->delete();

        return response()->json("done", 200);
    }

    public function addStudentClass(Request $request)
    {
        StudentClass::create([
            "student_id" => $request->studentId,
            "grade_id" => $request->classId
        ]);

        return response()->json("done", 200);
    }

    public function getAllStudentWithoutClass()
    {
        $period = Carbon::now()->year;
        $school_id = Auth::user()->school_id;

        $grade_id = Grade::where('school_id', $school_id)->pluck('id')->all();
        $user_id = User::where('school_id', $school_id)->pluck('id')->all();
        $student_id_class = StudentClass::whereIn('grade_id', $grade_id)->pluck('student_id')->all();
        $student = Student::whereNotIn('id', $student_id_class)
            ->whereIn('user_id', $user_id)
            ->select('id', 'student_code')->get();

        return response()->json($student, 200);
    }

    public function getStudentClass($class_id)
    {
        $studentClasses = StudentClass::where("grade_id", $class_id)->pluck('student_id')->all();
        $students = Student::whereIn('id', $studentClasses)->with('user')->get();

        return response()->json($students, 200);
    }

    public function removeStudentClass(Request $request)
    {
        $studentClass = StudentClass::where("student_id", $request->studentId)->where("grade_id", $request->classId)->first();
        $studentClass->delete();

        return response()->json($request->all(), 200);
    }

    public function getStudent($student_id)
    {
        $student = Student::where("id", $student_id)->with('user')->first();

        return response()->json($student, 200);
    }

    public function manageCourseView()
    {
        return view("user.staff.course");
    }

    public function getAllCourse()
    {
        $schoolId = Auth::user()->school_id;
        $courses = Course::where("school_id", $schoolId)->get();

        return response()->json($courses, 200);
    }

    public function addCourse(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        Course::create([
            "school_id" => $schoolId,
            "name" => $request->name
        ]);

        return response()->json($request->all(), 200);
    }

    public function findCourse($id)
    {
        $course = Course::where("id", $id)->first();

        return response()->json($course, 200);
    }

    public function editCourse(Request $request)
    {
        $course = Course::where("id", $request->id)->first();

        $course->update([
            "school_id" => $course->school_id,
            "name" => $request->name
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteCourse(Request $request)
    {
        $course = Course::where("id", $request->id)->first();
        $course->delete();

        return response()->json($request->all(), 200);
    }

    public function managePacketView()
    {
        return view('user.staff.packet');
    }

    public function getTeacherClassCourse($class_id)
    {
        $teacherClasses = TeacherClass::where("grade_id", $class_id)->with(["course", "teacher"])->get();

        foreach ($teacherClasses as $teacherClass) {
            $teacher = User::where("id", $teacherClass->teacher->user_id)->first();
            $teacherClass->teacher->name = $teacher->name;
        }

        return response()->json($teacherClasses, 200);
    }

    public function addTeacherClassCourse(Request $request)
    {
        TeacherClass::create([
            "teacher_id" => $request->teacherId,
            "grade_id" => $request->classId,
            "course_id" => $request->courseId
        ]);

        return response()->json($request->all(), 200);
    }

    public function getAllCourseClass($class_id)
    {
        $school_id = Auth::user()->school_id;

        $teacherClassId = TeacherClass::where("grade_id", $class_id)->pluck("course_id")->all();
        $courses = Course::where("school_id", $school_id)->whereNotIn("id", $teacherClassId)->get();

        return response()->json($courses, 200);
    }

    public function removeTeacherClassCourse($teacher_course_id)
    {
        $teacherClass = TeacherClass::where("id", $teacher_course_id)->first();
        $teacherClass->delete();

        return response()->json($teacher_course_id, 200);
    }

    public function manageScheduleShiftView()
    {
        return view('user.staff.shift');
    }

    public function getAllCourseForOption()
    {
        $schoolId = Auth::user()->school_id;
        $courses = Course::where("school_id", $schoolId)->select(['name', 'id'])->get();

        return response()->json($courses, 200);
    }

    public function addPacket(Request $request)
    {
        $courseId = $request->courseId;
        $type = $request->type;
        $name = $request->name;
        $totalUsedQuestion = $request->totalUsedQuestion;
        $schoolId = Auth::user()->school_id;

        $packet = Packet::create([
            'course_id' => $courseId,
            'type' => $type,
            'name' => $name,
            'total_used_question' => $totalUsedQuestion,
            'school_id' => $schoolId,
            'level' => $request->level
        ]);

        return response()->json($packet, 200);
    }

    public function getAllPacket()
    {
        $schoolId = Auth::user()->school_id;
        $packets = Packet::where('school_id', $schoolId)->with('course')->get();

        return response()->json($packets, 200);
    }

    public function getAllExamPacket()
    {
        $schoolId = Auth::user()->school_id;
        $packets = Packet::where('school_id', $schoolId)->where('type', 'Exam')->with('course')->get();

        return response()->json($packets, 200);
    }

    public function getPacketById($packet_id)
    {
        $packet = Packet::where('id', $packet_id)->first();

        return response()->json($packet, 200);
    }

    public function editPacket(Request $request)
    {
        $packet = Packet::where('id', $request->packetId)->first();
        $courseId = $request->courseId;
        $type = $request->type;
        $name = $request->name;
        $totalUsedQuestion = $request->totalUsedQuestion;
        $schoolId = Auth::user()->school_id;

        $packet->update([
            'course_id' => $courseId,
            'type' => $type,
            'name' => $name,
            'total_used_question' => $totalUsedQuestion,
            'school_id' => $schoolId,
            'level' => $request->level
        ]);

        return response()->json($packet, 200);
    }

    public function deletePacket(Request $request)
    {
        $packet = Packet::where('id', $request->id)->first();
        $packet->delete();

        return response()->json($packet, 200);
    }

    public function getAllTeacherForOption($packet_id)
    {
        $schoolId = Auth::user()->school_id;

        $contributorTeachers = ContributorTeacher::where("packet_id", $packet_id)->pluck('teacher_id');
        $users = User::where("school_id", $schoolId)->where("role", "teacher")->pluck("id");
        $teachers = Teacher::whereNotIn("id", $contributorTeachers)
            ->whereIn("user_id", $users)
            ->select(['id', 'teacher_code as code'])
            ->get();

        return response()->json($teachers, 200);
    }

    public function getTeacherNameByTeacherId($teacher_id)
    {
        $teacher = Teacher::where('id', $teacher_id)->first();
        $user = User::where('id', $teacher->user_id)->first();

        return response()->json($user->name, 200);
    }

    public function getPacketContributor($packet_id)
    {
        $contributorTeachers = ContributorTeacher::where("packet_id", $packet_id)->with('teacher')->get();

        $response = [];

        foreach ($contributorTeachers as $key => $contributorTeacher) {
            $response[$key]['id'] = $contributorTeacher->id;
            $user = User::where("id", $contributorTeacher->teacher->user_id)->select('name')->first();
            $response[$key]['name'] = $user->name;
        }

        return response()->json($response, 200);
    }

    public function addPacketContributor(Request $request)
    {
        $packet = ContributorTeacher::create([
            'teacher_id' => $request->teacherId,
            'packet_id' => $request->packetId
        ]);

        return response()->json($packet, 200);
    }

    public function deletePacketContributor(Request $request)
    {
        $contributorTeacher = ContributorTeacher::where('id', $request->id)->first();
        $contributorTeacher->delete();

        return response()->json($contributorTeacher, 200);
    }

    public function getAllScheduleShift()
    {
        $schoolId = Auth::user()->school_id;
        $scheduleShifts = ScheduleShift::where('school_id', $schoolId)->orderBy("active_from_date", "asc")->orderBy("id", "asc")->get();

        return response()->json($scheduleShifts, 200);
    }

    public function addScheduleShift(Request $request)
    {
        $schoolId = Auth::user()->school_id;
        $activeFromDate = null;
        $activeUntilDate = null;
        if (!($request->checked)) {
            $activeFromDate = $request->activeFromDate;
            $activeUntilDate = $request->activeUntilDate;
        }

        $scheduleShift = ScheduleShift::create([
            'school_id' => $schoolId,
            'from' => $request->from,
            'until' => $request->until,
            'active_from_date' => $activeFromDate,
            'active_until_date' => $activeUntilDate,
            'shift' => $request->order
        ]);

        return response()->json($scheduleShift, 200);
    }

    public function editScheduleShift(Request $request)
    {
        $schoolId = Auth::user()->school_id;
        $activeFromDate = null;
        $activeUntilDate = null;
        if (!($request->checked)) {
            $activeFromDate = $request->activeFromDate;
            $activeUntilDate = $request->activeUntilDate;
        }

        $scheduleShift = ScheduleShift::where("id", $request->id)->first();
        $scheduleShift->update([
            'school_id' => $schoolId,
            'from' => $request->from,
            'until' => $request->until,
            'active_from_date' => $activeFromDate,
            'active_until_date' => $activeUntilDate,
            'shift' => $request->order
        ]);

        return response()->json($request->all(), 200);
    }

    public function getScheduleShift(Request $request)
    {
        $scheduleShift = ScheduleShift::where("id", $request->id)->first();

        return response()->json($scheduleShift, 200);
    }

    public function deleteScheduleShift(Request $request)
    {
        $scheduleShift = ScheduleShift::where("id", $request->id)->first();
        $scheduleShift->delete();

        return response()->json($scheduleShift, 200);
    }

    public function manageClassScheduleView()
    {
        return view('user.staff.class-schedule');
    }

    public function getSelectedCourse($day, $shift, $classId)
    {
        $teacherClass = TeacherClass::where('grade_id', $classId);
        $teacherId = $teacherClass->pluck('teacher_id');
        $courseId = $teacherClass->pluck('course_id');
        $scheduleClassTeacherId = ScheduleClass::where("day", $day)
            ->where('order', $shift)
            ->whereIn('teacher_id', $teacherId)
            ->whereNotIn('grade_id', [$classId])
            ->pluck('teacher_id');

        if ($scheduleClassTeacherId->isEmpty()) {
            $courses = Course::whereIn("id", $courseId)
                ->select("id", "name")
                ->get();
        } else {
            $teacherClass = $teacherClass->whereIn("teacher_id", $scheduleClassTeacherId)->pluck("course_id");

            $courses = Course::whereIn("id", $courseId)
                ->whereNotIn("id", $teacherClass)
                ->select("id", "name")
                ->get();
        }

        return response()->json($courses, 200);
    }

    public function addSchedule(Request $request)
    {
        $teacherClass = TeacherClass::where("grade_id", $request->classId)->where("course_id", $request->courseId)->first();

        $scheduleClass = ScheduleClass::where("order", $request->shift)->where("day", $request->day)->where("grade_id", $request->classId)->first();

        if ($scheduleClass == null) {
            ScheduleClass::create([
                "teacher_id" => $teacherClass->teacher_id,
                "grade_id" => $request->classId,
                "course_id" => $request->courseId,
                "order" => $request->shift,
                "day" => $request->day
            ]);
        } else {
            $scheduleClass->update([
                "teacher_id" => $teacherClass->teacher_id,
                "grade_id" => $request->classId,
                "course_id" => $request->courseId,
                "order" => $request->shift,
                "day" => $request->day
            ]);
        }

        return response()->json($request->all(), 200);
    }

    public function getAllClassSchedule($class_id)
    {
        $scheduleClasses = ScheduleClass::where("grade_id", $class_id)->with(["teacher", "course"])->get();
        foreach ($scheduleClasses as $scheduleClass) {
            $user = User::where("id", $scheduleClass->teacher->user_id)->first();
            $scheduleClass->teacher->name = $user->name;
        }

        return response()->json($scheduleClasses, 200);
    }

    public function deleteSchedule(Request $request)
    {
        $scheduleClass = ScheduleClass::where("order", $request->shift)->where("day", $request->day)->where("grade_id", $request->classId)->first();

        $scheduleClass->delete();

        return response()->json($request->all(), 200);
    }

    public function addTuition(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        foreach ($request->class as $grade) {
            $studentClasses = StudentClass::where("grade_id", $grade)->with(["student" => function ($query) {
                $query->with(["user", "guardian" => function ($query) {
                    $query->with("user");
                }]);
            }])->get();

            $tuition = Tuition::create([
                "school_id" => $schoolId,
                "price" => $request->price,
                "due_date" => $request->dueDate,
                "description" => $request->description
            ]);

            foreach ($studentClasses as $studentClass) {
                $studentEmail = $studentClass->student->user->email;
                $guardianEmail = $studentClass->student->guardian->user->email;

                TuitionHistory::create([
                    "tuition_id" => $tuition->id,
                    "student_id" => $studentClass->student->id,
                    "class_id" => $studentClass->grade_id,
                    "status" => "unpaid",
                ]);

                $data = [
                    "price" => number_format($request->price, "0", ",", "."),
                    "description" => $request->description,
                    "dueDate" => Carbon::parse($request->dueDate)->format("d M Y"),
                    "name" => $studentClass->student->user->name,
                    "guardian_name" => $studentClass->student->guardian->user->name
                ];

                Mail::to($studentEmail)->send(new SendEmailTuition('Tuition', $data));
                Mail::to($guardianEmail)->send(new SendEmailTuitionParent('Tuition', $data));
            }
        }

        return response()->json($request->all(), 200);
    }

    public function getTuitionByClassId($class_id)
    {
        $tuitionHistory = TuitionHistory::where("class_id", $class_id)->with(["tuition", "student" => function ($query) {
            $query->with("user");
        }])->get()->groupBy("tuition_id");

        return response()->json($tuitionHistory, 200);
    }

    public function createScheduleHoliday(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        $startDate = new \DateTime($request->startDate);
        $endDate = new \DateTime($request->endDate);
        $endDate->modify('+1 day');

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($startDate, $interval, $endDate);

        foreach ($period as $dt) {
            ScheduleDetail::create([
                "class_id" => $request->classId,
                "school_id" => $schoolId,
                "schedule_type" => "holiday",
                "name" => $request->name,
                "date" => $dt->format("Y-m-d H:i:s"),
            ]);
        }

        return response()->json($request->all(), 200);
    }

    public function getHolidaySchedules($class_id)
    {
        $scheduleDetails = ScheduleDetail::where("schedule_type", "holiday")
            ->where("class_id", $class_id)
            ->orderBy('date', 'ASC')->get();

        return response()->json($scheduleDetails, 200);
    }

    public function removeHolidaySchedule(Request $request)
    {
        $scheduleDetail = ScheduleDetail::where("id", $request->id)->first();
        $scheduleDetail->delete();

        return response()->json($request->all(), 200);
    }

    public function createScheduleExam(Request $request)
    {
        $schoolId = Auth::user()->school_id;
        $date = new \DateTime($request->date);

        if($request->fullDay) {
            $scheduleDetail = ScheduleDetail::create([
                "class_id" => $request->classId,
                "school_id" => $schoolId,
                "schedule_type" => "exam",
                "name" => $request->name,
                "date" => $date->format("Y-m-d H:i:s"),
                "shift" => $request->shift
            ]);

            ScheduleDetailPacket::create([
                "packet_id" => $request->packetId,
                "schedule_detail_id" => $scheduleDetail->id
            ]);
        }

        return response()->json($request->all(), 200);
    }

    public function getExamSchedules($class_id)
    {
        $scheduleDetails = ScheduleDetail::where("schedule_type", "exam")
            ->where("class_id", $class_id)
            ->orderBy('date', 'ASC')->get();

        foreach ($scheduleDetails as $scheduleDetail) {
            $scheduleDetailPacket = ScheduleDetailPacket::where("schedule_detail_id", $scheduleDetail->id)
                ->with("packet")
                ->first();
            $scheduleDetail->schedule_detail_packet = $scheduleDetailPacket;
        }
        return response()->json($scheduleDetails, 200);
    }

    public function removeExamSchedule(Request $request)
    {
        $scheduleDetail = ScheduleDetail::where("id", $request->id)->first();
        $scheduleDetailPacket = ScheduleDetailPacket::where("schedule_detail_id", $scheduleDetail->id)->first();

        $scheduleDetailPacket->delete();
        $scheduleDetail->delete();

        return response()->json($request->all(), 200);
    }

    public function getExamScheduleById($id)
    {
        $scheduleDetail = ScheduleDetail::where("id", $id)->first();
        $scheduleDetail->schedule_detail_packet = ScheduleDetailPacket::where("schedule_detail_id", $scheduleDetail->id)->first();

        return response()->json($scheduleDetail, 200);
    }

    public function editExamSchedule(Request $request)
    {
        $date = new \DateTime($request->date);

        $scheduleDetail = ScheduleDetail::where("id", $request->scheduleDetailId)->first();
        $scheduleDetailPacket = ScheduleDetailPacket::where("schedule_detail_id", $request->scheduleDetailId)->first();

        $scheduleDetail->update([
            "class_id" => $request->classId,
            "schedule_type" => "exam",
            "name" => $request->name,
            "date" => $date->format("Y-m-d H:i:s"),
            "shift" => $request->shift
        ]);

        $scheduleDetailPacket->update([
            "packet_id" => $request->packetId,
        ]);
    }

    public function managePeriodView()
    {
        return view('user.staff.period');
    }

    public function createPeriod(Request $request)
    {
        $schoolId = Auth::user()->school_id;

        PeriodDateDetail::create([
            "period" => $request->period,
            "school_id" => $schoolId,
            "start_date" => $request->startDate,
            "end_date" => $request->endDate
        ]);

        return response()->json($request->all(), 200);
    }

    public function getAllPeriod()
    {
        $schoolId = Auth::user()->school_id;
        $periodDateDetails = PeriodDateDetail::where("school_id", $schoolId)->orderBy("period", "asc")->get();

        return response()->json($periodDateDetails, 200);
    }

    public function deletePeriod(Request $request)
    {
        $periodDateDetail = PeriodDateDetail::where("id", $request->id)->first();
        $periodDateDetail->delete();

        return response()->json($periodDateDetail, 200);
    }

    public function getPeriodById($id)
    {
        $periodDateDetail = PeriodDateDetail::where("id", $id)->first();

        return response()->json($periodDateDetail, 200);
    }

    public function editPeriod(Request $request)
    {
        $periodDateDetail = PeriodDateDetail::where("id", $request->periodId)->first();

        $periodDateDetail->update([
            "period" => $request->period,
            "start_date" => $request->startDate,
            "end_date" => $request->endDate
        ]);

        return response()->json($periodDateDetail, 200);
    }

    public function getPeriodForOption()
    {
        $schoolId = Auth::user()->school_id;
        $periodDateDetails = PeriodDateDetail::where("school_id", $schoolId)->orderBy("period", "asc")->select("period as value")->get();

        return response()->json($periodDateDetails, 200);
    }

    public function rejectTuition(Request $request)
    {
        $tuitionHistory = TuitionHistory::where("id", $request->id)->first();

        $tuitionHistory->update([
            "status" => "rejected"
        ]);

        return response()->json($request->all(), 200);
    }

    public function approveTuition(Request $request)
    {
        $tuitionHistory = TuitionHistory::where("id", $request->id)->first();

        $tuitionHistory->update([
            "status" => "approved"
        ]);

        return response()->json($request->all(), 200);
    }
}
