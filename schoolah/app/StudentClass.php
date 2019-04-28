<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $fillable = [
        'student_id', 'grade_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
