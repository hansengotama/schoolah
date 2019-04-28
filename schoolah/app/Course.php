<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'school_id', 'name'
    ];

    public function teacherClass()
    {
        return $this->hasMany(TeacherClass::class);
    }
}
