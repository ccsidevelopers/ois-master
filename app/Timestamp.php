<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timestamp extends Model
{
    protected $fillable = [
        'time_dispatcher', 'time_srao', 'time_ci', 'time_ao'
    ];
}
