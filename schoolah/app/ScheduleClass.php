<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleClass extends Model
{
    protected $fillable = [
        'teacher_id', 'grade_id', 'course_id', 'order', 'day'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
