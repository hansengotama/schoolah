<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPacket extends Model
{
    protected $fillable = [
        'student_id', 'packet_id', 'score'
    ];
}
