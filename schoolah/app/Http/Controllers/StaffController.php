<?php

namespace App\Http\Controllers;

use App\Grade;

use App\Guardian;
use App\Mail\SendEmail;
use App\School;
use App\Teacher;
use App\User;
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
        }

        return response()->json($teachers, 200);
    }

    public function addTeacher(Request $request)
    {
        $userId = Auth::user()->id;
        $staffLogin = User::where("id", $userId)->first();

        $schoolId = $staffLogin->school_id;
        $school = School::where('id', $schoolId)->first();

        $teacherPassword = strtolower($request->name) . $schoolId . "teacher";

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
            'avatar' => "asd"
        ]);

        Mail::to($request->email)->send(new SendEmail('Staff', $data));

        return response()->json($request->all(), 200);
    }

    public function getTeacher(Request $request)
    {
        $teacher = User::where("id", $request->id)->first();
        $teacherDetail = Teacher::where("user_id", $request->id)->first();
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

    public function manageClass()
    {
        return view('user.staff.class');
    }

    public function getGuardianTeacher()
    {
        $schoolId = Auth::user()->school_id;

        $teachers = User::where("school_id", $schoolId)
            ->where("role", "teacher")
            ->select('name', 'id')
            ->get();

        foreach ($teachers as $teacher) {
            $teacherDetail = Teacher::where("user_id", $teacher->id)->first();
            $teacher->value = $teacherDetail->id;
        }

        return response()->json($teachers, 200);
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

        $guardianPassword = strtolower($request->name) . $schoolId . "guardian";

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
            'avatar' => "asd"
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

    public function manageFinance()
    {
        return view('user.staff.finance');
    }
}