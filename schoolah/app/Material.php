<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'teacher_class_id', 'file', 'title', 'description'
    ];
}
