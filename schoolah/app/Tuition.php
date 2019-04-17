<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
{
    protected $fillable = [
        'student_id', 'school_id', 'price', 'period'
    ];
}
