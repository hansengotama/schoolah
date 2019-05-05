<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContributorTeacher extends Model
{
    protected $fillable = [
        'teacher_id', 'packet_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
