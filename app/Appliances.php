<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliances extends Model
{
    //
    protected $fillable = [
        'name', 'normal_power', 'alternate_power', 'description'
    ];

}
