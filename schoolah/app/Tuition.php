<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
{
    protected $fillable = [
        'school_id', 'price', 'description', 'due_date'
    ];

    public function tuitionHistory()
    {
        return $this->hasMany(TuitionHistory::class);
    }
}
