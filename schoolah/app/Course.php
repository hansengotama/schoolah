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

    public function packet()
    {
        return $this->hasMany(Packet::class);
    }

    public function scheduleClass()
    {
        return $this->hasOne(ScheduleClass::class);
    }
}
