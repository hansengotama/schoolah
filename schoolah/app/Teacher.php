<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id', 'teacher_code', 'avatar'
    ];

    protected $appends = [
        'avatar_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacherClass()
    {
        return $this->hasMany(TeacherClass::class);
    }

    public function contributorTeacher()
    {
        return $this->hasOne(ContributorTeacher::class);
    }

    public function scheduleClass()
    {
        return $this->hasOne(ScheduleClass::class);
    }

    public function getAvatarUrlAttribute()
    {
        return ($this->avatar) ? url('/').$this->avatar : null;
    }
}
