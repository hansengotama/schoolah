<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'student_id', 'grade_id', 'school_id', 'average_score', 'rank'
    ];
}
