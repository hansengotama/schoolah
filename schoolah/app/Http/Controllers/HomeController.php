<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Student;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function resetPassword()
    {
        return view('reset-password');
    }

    public function resetAvatar()
    {
        return view('reset-avatar');
    }

    public function resetAvatarAction(Request $request)
    {
        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        if ($userRole == "teacher") {
            $image = $request->file->store('/public/teacher');
            $userDetail = Teacher::where("user_id", $userId)->first();
            $userDetail->update([
                "avatar" => $image
            ]);
        }

        if ($userRole == "student") {
            $image = $request->file->store('/public/student');
            $userDetail = Student::where("user_id", $userId)->first();
            $userDetail->update([
                "avatar" => $image
            ]);
        }

        return response()->json($image, 200);
    }

    public function resetPasswordAction(Request $request)
    {
        $newPassword = $request->password;

        $userId = Auth::user()->id;

        $user = User::where('id', $userId)->first();

        $user->update([
            'password' => bcrypt($newPassword),
            'is_change_password' => true
        ]);

        return response()->json("done", 200);
    }

    public function getUserData()
    {
        $user = Auth::user();
        if ($user->role == "student") {
            $userDetail = Student::where("user_id", $user->id)->first();
        }

        if ($user->role == "teacher") {
            $userDetail = Teacher::where("user_id", $user->id)->first();
        }

        if ($user->role == "student" || $user->role == "teacher") {
            $user->avatar = $userDetail->avatar;
            $user->teacher_code = $userDetail->teacher_code;
        }

        return $user;
    }

    public function editProfileView()
    {
        return view("edit-profile");
    }

    public function editProfileAction(Request $request)
    {
        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        if (isset($request->file)) {
            if ($userRole == "teacher") {
                $userDetail = Teacher::where("user_id", $userId)->first();
                $avatarBefore = $userDetail->avatar;
                Storage::delete($avatarBefore);

                $image = $request->file->store('/public/teacher');
                $userDetail->update([
                    "avatar" => $image,
                ]);
            }

            if ($userRole == "student") {
                $userDetail = Student::where("user_id", $userId)->first();
                $avatarBefore = $userDetail->avatar;
                Storage::delete($avatarBefore);

                $image = $request->file->store('/public/student');
                $userDetail->update([
                    "avatar" => $image
                ]);
            }
        }

        $user = User::where("id", $userId)->first();
        $user->update([
            "email" => $request->email,
            "phone_number" => $request->phoneNumber,
            "address" => $request->address
        ]);

        return response()->json($request->all(), 200);
    }

    public function addFeedback(Request $request)
    {
        $userId = Auth::user()->id;
        Feedback::create([
            "user_id" => $userId,
            "feedback" => $request->feedback,
        ]);

        return response()->json($request->all(), 200);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
