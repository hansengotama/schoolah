<?php

namespace App\Http\Controllers;

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

        $teacherPassword = strtolower($request->name).$schoolId."teacher";

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

        Mail::to($request->email)->send( new SendEmail('Staff', $data) );

        return response()->json($request->all(), 200);
    }

    public function getTeacher(Request $request) {
        $teacher = User::where("id", $request->id)->first();
        $teacherDetail = Teacher::where("user_id", $request->id)->first();
        $teacher->teacher_code = $teacherDetail->teacher_code;

        return response()->json($teacher, 200);
    }

    public function editTeacher(Request $request) {
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

    public function deleteTeacher(Request $request) {
        Teacher::where("user_id", $request->id)->delete();
        User::where("id", $request->id)->delete();

        return response()->json($request->all(), 200);
    }

    public function manageStudentView()
    {
        return view('user.staff.student');
    }


    public function manageGuardianView()
    {
        return view('user.staff.guardian');
    }

    public function manageClass()
    {
        return view('user.staff.class');
    }

    public function manageFinance()
    {
        return view('user.staff.finance');
    }
}