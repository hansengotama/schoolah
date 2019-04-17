<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    protected $fillable = [
        'student_packet_id', 'question_id', 'answer', 'is_right'
    ];
}
