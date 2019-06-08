<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    protected $fillable = [
        'student_packet_id', 'question_id', 'question_choice_id'
    ];

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function questionChoice() {
        return $this->belongsTo(QuestionChoice::class);
    }
}
