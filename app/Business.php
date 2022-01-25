<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    //
    protected $fillable = [
        'business_name', 'business_address','business_municipality', 'business_province'
    ];
}
