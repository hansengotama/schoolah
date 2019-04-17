<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherClass extends Model
{
    protected $fillable = [
        'grade_id', 'teacher_id', 'course_id'
    ];
}
