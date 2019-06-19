<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    protected $fillable = [
        'assignment_id', 'student_id', 'answer_file', 'teacher_comment', 'score'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
