<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    protected $fillable = [
        'schedule_class_id', 'school_id', 'schedule_type', 'name', 'start_date', 'end_date'
    ];
}
