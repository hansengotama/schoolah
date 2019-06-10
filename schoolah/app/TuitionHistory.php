<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TuitionHistory extends Model
{
    protected $fillable = [
        'tuition_id', 'class_id', 'student_id', 'status', 'payment_receipt'
    ];

    protected $appends = [
        'payment_receipt_url'
    ];

    public function tuition()
    {
        return $this->belongsTo(Tuition::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getPaymentReceiptUrlAttribute() {
        return ($this->payment_receipt) ? url('/').$this->payment_receipt : null;
    }


}
