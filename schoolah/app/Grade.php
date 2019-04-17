<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'school_id', 'guardian_teacher_id', 'name', 'level', 'period'
    ];
}
