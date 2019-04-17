<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return $user;
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
