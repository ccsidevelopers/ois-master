<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coborrower extends Model
{
    protected $fillable = [
        'coborrower_name', 'coborrower_address','coborrower_municipality', 'coborrower_province'
    ];
}
