<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = ['id','title','description','type','repeat','start_date','end_date'];
}
