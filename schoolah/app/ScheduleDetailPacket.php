<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDetailPacket extends Model
{
    protected $fillable = [
        'packet_id', 'schedule_detail_id'
    ];
}
