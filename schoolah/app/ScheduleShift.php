<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleShift extends Model
{
    protected $fillable = [
        'shift', 'school_id', 'from', 'until', 'active_from_date', 'active_until_date'
    ];
}
