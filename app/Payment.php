<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'month', 'status', 'year', 'units', 'amount', 'remarks', 'assessment_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
