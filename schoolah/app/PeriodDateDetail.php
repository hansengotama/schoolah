<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodDateDetail extends Model
{
    protected $fillable = [
        'school_id', 'period', 'start_date', 'end_date'
    ];
}
