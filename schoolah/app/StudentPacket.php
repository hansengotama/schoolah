<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPacket extends Model
{
    protected $fillable = [
        'student_id', 'packet_id', 'score'
    ];

    public function studentAnswers() {
        return $this->hasMany(StudentAnswer::class);
    }

    public function packet() {
        return $this->belongsTo(Packet::class);
    }
}
