<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'schedule_detail_id', 'file', 'title', 'description'
    ];
}
