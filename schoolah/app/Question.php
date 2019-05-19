<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'packet_id', 'text'
    ];

    public function questionChoices()
    {
        return $this->hasMany(QuestionChoice::class);
    }
}
