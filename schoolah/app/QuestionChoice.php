<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{
    protected $fillable = [
        'question_id', 'text', 'is_answer'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
