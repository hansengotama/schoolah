<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\School;
use App\Staff;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function schoolView()
    {
        return view('user.admin.school');
    }

    public function getAllSchool()
    {
        $school = School::get();

        return response()->json($school, 200);
    }

    public function getSchool(Request $request)
    {
        $school = School::where("id", $request->id)->first();

        return response()->json($school, 200);
    }

    public function addSchool(Request $request)
    {
        School::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phoneNumber,
        ]);

        return response()->json($request->all(), 200);
    }

    public function editSchool(Request $request)
    {
        $school = School::where("id", $request->id)->first();

        $school->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phoneNumber,
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteSchool(Request $request)
    {
        $school = School::where('id', $request->id)->first();
        $school->delete();

        return response()->json($request->all(), 200);
    }

    public function getStaff(Request $request)
    {
        $staff = User::where('school_id', $request->school_id)->where('role', 'staff')->get();

        return response()->json($staff, 200);
    }

    public function addStaff(Request $request)
    {
        $staffPassword = strtolower($request->name).$request->school_id."staff";
        $school = School::where('id', $request->school_id)->first();

        $data = [
            "school_name" => $school->name,
            "password" => $staffPassword,
            "role" => 'staff'
        ];
        $data = array_merge($data, $request->all());

        $staff = User::create([
            'name' => $request->name,
            'role' => 'staff',
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phoneNumber,
            'school_id' => $request->school_id,
            'password' => bcrypt($staffPassword),
            'is_change_password' => false
        ]);

        Staff::create([
            'user_id' => $staff->id
        ]);

        Mail::to($request->email)->send( new SendEmail('Staff', $data) );

        return response()->json($request->all(), 200);
    }

    public function findStaff(Request $request)
    {
        $staff = User::where("id", $request->id)->first();

        return response()->json($staff, 200);
    }

    public function editStaff(Request $request)
    {
        $staff = User::where("id", $request->id)->first();

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'school_id' => $request->school_id,
            'role' => 'staff',
            'phone_number' => $request->phoneNumber,
            'password' => $staff->password,
            'is_change_password' => $staff->is_change_password
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteStaff(Request $request)
    {
        Staff::where("user_id", $request->id)->delete();
        User::where("id", $request->id)->delete();
        
        return response()->json($request->all(), 200);
    }
}
