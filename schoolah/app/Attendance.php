<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        "schedule_class_id", "student_id", "status", "session"
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function scheduleClass()
    {
        return $this->belongsTo(ScheduleClass::class);
    }
}
