<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = [
        'teacher_class_id', 'chat', 'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
