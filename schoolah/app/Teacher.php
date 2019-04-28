<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id', 'teacher_code', 'avatar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacherClass()
    {
        return $this->hasMany(TeacherClass::class);
    }
}
