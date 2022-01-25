<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $fillable = [
        'employer_name', 'employer_address','employer_municipality', 'employer_province'
    ];
}
