<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'schedule_detail_id', 'name', 'description', 'question_file', 'start_date', 'end_date'
    ];
}
