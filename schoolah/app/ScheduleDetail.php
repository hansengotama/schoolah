<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    protected $fillable = [
        'class_id', 'schedule_class_id', 'school_id', 'schedule_type', 'name', 'date', 'shift'
    ];
}
