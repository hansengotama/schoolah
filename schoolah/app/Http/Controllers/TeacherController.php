<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
