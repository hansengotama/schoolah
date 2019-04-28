<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'school_id', 'guardian_teacher_id', 'name', 'level', 'period'
    ];

    public function studentClass()
    {
        return $this->hasMany(StudentClass::class);
    }

    public function teacherClass()
    {
        return $this->hasMany(TeacherClass::class);
    }
}
