<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = [
        'student_id', 'schedule_detail_id', 'is_absence'
    ];
}
