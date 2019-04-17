<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCourse extends Model
{
    protected $fillable = [
        'course_id', 'report_id', 'score'
    ];
}
