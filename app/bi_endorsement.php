<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bi_endorsement extends Model
{
    //
    public function checkings()
    {
        return $this->hasMany('App/bi_endorsements_checking');
    }
}
