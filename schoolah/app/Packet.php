<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    protected $fillable = [
        'school_id', 'course_id', 'total_used_question', 'name', 'type'
    ];
}
