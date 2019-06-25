<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'teacher_class_id', 'name', 'description', 'question_file', 'due_date'
    ];

    protected $appends = [
        'question_file_url'
    ];

    public function getQuestionFileUrlAttribute()
    {
        return url('/').$this->question_file;
    }

    public function teacherClass()
    {
        return $this->belongsTo(TeacherClass::class);
    }
}
