<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'guardian_id', 'user_id', 'student_code', 'avatar'
    ];
}
