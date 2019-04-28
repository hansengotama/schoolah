<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherClass extends Model
{
    protected $fillable = [
        'grade_id', 'teacher_id', 'course_id'
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function grade() {
        return $this->belongsTo(Grade::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
}
